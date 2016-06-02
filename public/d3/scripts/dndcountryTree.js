// Get JSON data

function tree(error, treeData) {

    //if json has error then preventing to create a tree
    if(error !== undefined && error !== null){
        return;
    }

    // Calculate total nodes, max label length
    var totalNodes = 0;
    var maxLabelLength = 0;
    // variables for drag/drop
    var selectedNode = null;
    var draggingNode = null;
    // panning variables
    var panSpeed = 200;
    var panBoundary = 20; // Within 20px from edges will pan when dragging.
    // Misc. variables
    var i = 0;
    var duration = 750;
    var root;

    // size of the diagram
    var viewerWidth = $(document).width()/1.224;
    var viewerHeight = $(document).height()/1.5;

    var tree = d3.layout.tree()
        .size([viewerHeight, viewerWidth]);

    // define a d3 diagonal projection for use by the node paths later on.
    var diagonal = d3.svg.diagonal()
        .projection(function(d) {
            return [d.x, d.y];
        });

    // A recursive helper function for performing some setup by walking through all nodes

    function visit(parent, visitFn, childrenFn) {
        if (!parent) return;

        visitFn(parent);

        var children = childrenFn(parent);
        if (children) {
            var count = children.length;
            for (var i = 0; i < count; i++) {
                visit(children[i], visitFn, childrenFn);
            }
        }
    }

    // Call visit function to establish maxLabelLength
    visit(treeData.tree, function(d) {
        totalNodes++;
        maxLabelLength = Math.max(d.name.length, maxLabelLength);

    }, function(d) {
        return d.children && d.children.length > 0 ? d.children : null;
    });

    //setting nodes after second level as minified
    if(treeData.tree.children){
        treeData.tree.children.forEach(function (child) {
            //if child has children
            if(child.children){
                child.children.forEach(function (childChildren) {
                    childChildren._children = childChildren.children;
                    childChildren.children = null;
                });
            }
        });
    }
    


    // sort the tree according to the node names
    function sortTree() {
        tree.sort(function(a, b) {
            return b.name.toLowerCase() < a.name.toLowerCase() ? 1 : -1;
        });
    }
    // Sort the tree initially incase the JSON isn't in a sorted order.
    sortTree();

    // TODO: Pan function, can be better implemented.

    function pan(domNode, direction) {
        var speed = panSpeed;
        if (panTimer) {
            clearTimeout(panTimer);
            translateCoords = d3.transform(svgGroup.attr("transform"));
            if (direction == 'left' || direction == 'right') {
                translateX = direction == 'left' ? translateCoords.translate[0] + speed : translateCoords.translate[0] - speed;
                translateY = translateCoords.translate[1];
            } else if (direction == 'up' || direction == 'down') {
                translateX = translateCoords.translate[0];
                translateY = direction == 'up' ? translateCoords.translate[1] + speed : translateCoords.translate[1] - speed;
            }
            scaleX = translateCoords.scale[0];
            scaleY = translateCoords.scale[1];
            scale = zoomListener.scale();
            svgGroup.transition().attr("transform", "translate(" + translateX + "," + translateY + ")scale(" + scale + ")");
            d3.select(domNode).select('g.node').attr("transform", "translate(" + translateX + "," + translateY + ")");
            zoomListener.scale(zoomListener.scale());
            zoomListener.translate([translateX, translateY]);
            panTimer = setTimeout(function() {
                pan(domNode, speed, direction);
            }, 50);
        }
    }

    // Define the zoom function for the zoomable tree

    function zoom() {
        svgGroup.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
    }


    // define the zoomListener which calls the zoom function on the "zoom" event constrained within the scaleExtents
    var zoomListener = d3.behavior.zoom().scaleExtent([0.1, 3]).on("zoom", zoom);

    function initiateDrag(d, domNode) {
        draggingNode = d;
        d3.select(domNode).select('.ghostCircle').attr('pointer-events', 'none');
        d3.selectAll('.ghostCircle').attr('class', 'ghostCircle show');
        d3.select(domNode).attr('class', 'node activeDrag');

        svgGroup.selectAll("g.node").sort(function(a, b) { // select the parent and sort the path's
            if (a.id != draggingNode.id) return 1; // a is not the hovered element, send "a" to the back
            else return -1; // a is the hovered element, bring "a" to the front
        });
        // if nodes has children, remove the links and nodes
        if (nodes.length > 1) {
            // remove link paths
            links = tree.links(nodes);
            nodePaths = svgGroup.selectAll("path.link")
                .data(links, function(d) {
                    return d.target.id;
                }).remove();
            // remove child nodes
            nodesExit = svgGroup.selectAll("g.node")
                .data(nodes, function(d) {
                    return d.id;
                }).filter(function(d, i) {
                    if (d.id == draggingNode.id) {
                        return false;
                    }
                    return true;
                }).remove();
        }

        // remove parent link
        parentLink = tree.links(tree.nodes(draggingNode.parent));
        svgGroup.selectAll('path.link').filter(function(d, i) {
            if (d.target.id == draggingNode.id) {
                return true;
            }
            return false;
        }).remove();

        dragStarted = null;
    }

    // define the baseSvg, attaching a class for styling and the zoomListener
    var baseSvg = d3.select("#tree-container").append("svg")
        .attr("width", viewerWidth)
        .attr("height", viewerHeight)
        .attr("class", "overlay")
        .call(zoomListener);
    
    var modal = $('#modal-template');

    // Define the drag listeners for drag/drop behaviour of nodes.
    dragListener = d3.behavior.drag()
        .on("dragstart", function(d) {
            if (d == root) {
                return;
            }
            dragStarted = true;
            nodes = tree.nodes(d);
            d3.event.sourceEvent.stopPropagation();
            // it's important that we suppress the mouseover event on the node being dragged. Otherwise it will absorb the mouseover event and the underlying node will not detect it d3.select(this).attr('pointer-events', 'none');
        })
        .on("drag", function(d) {
            if (d == root) {
                return;
            }
            if (dragStarted) {
                domNode = this;
                initiateDrag(d, domNode);
            }

            // get coords of mouseEvent relative to svg container to allow for panning
            relCoords = d3.mouse($('svg').get(0));
            if (relCoords[0] < panBoundary) {
                panTimer = true;
                pan(this, 'left');
            } else if (relCoords[0] > ($('svg').width() - panBoundary)) {

                panTimer = true;
                pan(this, 'right');
            } else if (relCoords[1] < panBoundary) {
                panTimer = true;
                pan(this, 'up');
            } else if (relCoords[1] > ($('svg').height() - panBoundary)) {
                panTimer = true;
                pan(this, 'down');
            } else {
                try {
                    clearTimeout(panTimer);
                } catch (e) {

                }
            }

            d.y0 += d3.event.dy;
            d.x0 += d3.event.dx;
            var node = d3.select(this);
            node.attr("transform", "translate(" + d.x0 + "," + d.y0 + ")");
            updateTempConnector();
        }).on("dragend", function(d) {

            if (d == root) {
                return;
            }
            domNode = this;
            if (selectedNode) {
                
                window.selectedNode     = selectedNode;
                window.selectedNodeTemp = selectedNode;
                window.draggingNode     = draggingNode;
                
                
                modal.modal();

            } else {
                endDrag();
            }
        });

    //if click on no button on modal               
    modal.find('.modal-footer #not-confirm').on('click', function(){

        modal.modal('toggle');
        endDrag();
        return false;
    });
    
    //if click on yes button on modal
    modal.find('.modal-footer #confirm').on('click', function(){

        // hit webservice for update of tree data and on success only update the tree view
        $.post( "/tree/updatejson", { parent:window.selectedNode.user_id, user:window.draggingNode.user_id} )
            .done(function() {
                modal.modal('toggle');
                // now remove the element from the parent, and insert it into the new elements children
                var index = window.draggingNode.parent.children.indexOf(window.draggingNode);
                if (index > -1) {
                    window.draggingNode.parent.children.splice(index, 1);
                }
                if (typeof window.selectedNodeTemp.children !== 'undefined' || typeof window.selectedNodeTemp._children !== 'undefined') {
                    if (typeof window.selectedNodeTemp.children !== 'undefined') {
                        window.selectedNodeTemp.children.push(window.draggingNode);
                    } else {
                        window.selectedNodeTemp._children.push(window.draggingNode);
                    }
                } else {
                    window.selectedNodeTemp.children = [];
                    window.selectedNodeTemp.children.push(window.draggingNode);
                }
                // Make sure that the node being added to is expanded so user can see added node is correctly moved
                expand(window.selectedNodeTemp);
                sortTree();
                endDrag();
            })
            .fail(function() {
                                
                endDrag();
                return false;
            });
        });

    function endDrag() {
        selectedNode = null;
        d3.selectAll('.ghostCircle').attr('class', 'ghostCircle');
        d3.select(domNode).attr('class', 'node');
        // now restore the mouseover event or we won't be able to drag a 2nd time
        d3.select(domNode).select('.ghostCircle').attr('pointer-events', '');
        updateTempConnector();
        if (draggingNode !== null) {
            update(root);
            centerNode(draggingNode);
            draggingNode = null;
        }
    }

    // Helper functions for collapsing and expanding nodes.

    function collapse(d) {
        if (d.children) {
            d._children = d.children;

            d._children.forEach(collapse);
            d.children = null;
        }
    }

    function expand(d) {
        if (d._children) {
            d.children = d._children;
            d.children.forEach(expand);
            d._children = null;
        }
    }

    var overCircle = function(d) {
        selectedNode = d;
        updateTempConnector();
    };
    var outCircle = function(d) {
        selectedNode = null;
        updateTempConnector();
    };

    // Function to update the temporary connector indicating dragging affiliation
    var updateTempConnector = function() {
        var data = [];
        if (draggingNode !== null && selectedNode !== null) {
            // have to flip the source coordinates since we did this for the existing connectors on the original tree
            data = [{
                source: {
                    x: selectedNode.x0,
                    y: selectedNode.y0
                },
                target: {
                    x: draggingNode.x0,
                    y: draggingNode.y0
                }
            }];
        }
        var link = svgGroup.selectAll(".templink").data(data);

        link.enter().append("path")
            .attr("class", "templink")
            .attr("d", d3.svg.diagonal())
            .attr('pointer-events', 'none');

        link.attr("d", d3.svg.diagonal());

        link.exit().remove();
    };

    // Function to center node when clicked/dropped so node doesn't get lost when collapsing/moving with large amount of children.

    function centerNode(source) {
        scale = zoomListener.scale();
        x = -source.x0;
        y = -source.y0;
        x = x * scale + viewerWidth / 2;
        y = y * scale + viewerHeight / 2;
        d3.select('g').transition()
            .duration(duration)
            .attr("transform", "translate(" + x + "," + y + ")scale(" + scale + ")");
        zoomListener.scale(scale);
        zoomListener.translate([x, y]);
    }function topNode(source) {
        scale = zoomListener.scale();
        x = -source.x0;
        y = -source.y0;
        x = x * scale + viewerWidth / 2;
        y = y * scale + viewerHeight / 8; //had to be modified when changing from horizontal to vertical tree.
        d3.select('g').transition()
            .duration(duration)
            .attr("transform", "translate(" + x + "," + y + ")scale(" + scale + ")");
        zoomListener.scale(scale);
        zoomListener.translate([x, y]);
    }

    // Toggle children function

    function toggleChildren(d) {
        if (d.children) {
            d._children = d.children;
            d.children = null;
        } else if (d._children) {
            d.children = d._children;
            d._children = null;
        }
        return d;
    }

    // Toggle children on click.

    function click(d) {
        if (d3.event.defaultPrevented) return; // click suppressed
        d = toggleChildren(d);
        update(d);
        if(d!=root){
        centerNode(d);}
        else topNode(d);
    }

    function update(source) {
        // Compute the new height, function counts total children of root node and sets tree height accordingly.
        // This prevents the layout looking squashed when new nodes are made visible or looking sparse when nodes are removed
        // This makes the layout more consistent.
        var levelWidth = [1];
        var childCount = function(level, n) {

            if (n.children && n.children.length > 0) {
                if (levelWidth.length <= level + 1) levelWidth.push(0);

                levelWidth[level + 1] += n.children.length;
                n.children.forEach(function(d) {
                    childCount(level + 1, d);
                });
            }
        };
        childCount(0, root);
        var newHeight = d3.max(levelWidth) * 25; // 25 pixels per line  
        tree = tree.size([viewerWidth,newHeight ]);

        // Compute the new tree layout.
        var nodes = tree.nodes(root).reverse(),
            links = tree.links(nodes);

        // Set widths between levels based on maxLabelLength.
        nodes.forEach(function(d) {
            d.y = (d.depth * (maxLabelLength * 15)); //maxLabelLength * 15px
            // alternatively to keep a fixed scale one can set a fixed depth per level
            // Normalize for fixed-depth by commenting out below line
           d.y = (d.depth * 120); //120px per level.
        });

        // Update the nodes…
        node = svgGroup.selectAll("g.node")
            .data(nodes, function(d) {
                return d.id || (d.id = ++i);
            });


        var div = d3.select("body").append("div")
            .attr("class", "tooltip")
            .style("opacity", 0);


        // Enter any new nodes at the parent's previous position.
        var nodeEnter = node.enter().append("g")
            .call(dragListener)
            .attr("class", "node")
            .attr("transform", function(d) {
                return "translate(" + source.x0 + "," + source.y0 + ")";
            })
            .on('click', click);
        
        nodeEnter.append("image")
            .attr('id', function (d) {
                return "image-" + d.id;
            })
            .attr("xlink:href", function(d){return d.icon;})
            .attr("x", "-21px")
            .attr("y", "-21px")
            .attr("width","40px")
            .attr("height","40px")
            .on("mouseover", function(d) {
                div.transition()
                    .duration(500)
                    .style("opacity", 0);})
            .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; })
            .attr("clip-path", "url(#clip-profile)");


        nodeEnter.append("text")
            .attr("y", function(d) {
                if(d.parent_url === d.url){
                    return 30;
                }
                return -30;
            })
            .attr("dy", ".45em")
            .attr('class', 'nodeText')
            .attr("text-anchor", "middle")
            .text(function(d) {
                return d.name ;
            })
            .style('fill','#808080')
            .style('font-weight','bold')
            .style('font-size', function (d) {
                if(d.url === d.parent_url){
                    return "20px";
                }

                return "inherit";
            })
            .style("fill-opacity", 0);

      /*
        nodeEnter.append("circle")
        .attr("cx", 19)
        .attr("cy", 12)
        .attr("r", 10)
        .attr('class', 'total-circle');
*/
        nodeEnter.append("text")
            .attr("y", 7)
            .attr("dy", "1em")
            .attr('class', 'total-node-text')
            .text(function(d) {
                return d.total;
            })
            .attr('x', function (d) {
                nodeTotal = parseInt(d.total);
                //check length of total 
                if(nodeTotal <= 9) {
                    return 17;
                } 

                if(nodeTotal <= 99) {
                    return 14;
                } 

                if(nodeTotal <= 999) {
                    return 12;
                } 

                if(nodeTotal <= 9999) {
                    return 10;
                } 

            })
            .style("fill-opacity", 2);

        // phantom node to give us mouseover in a radius around it
    
        nodeEnter.append("circle")
           .attr('class', 'ghostCircle')
           .attr("r", 30)
           .attr("opacity", 0.2) // change this to zero to hide the target area
        .style("fill", "red")
           .attr('pointer-events', 'mouseover')
           .on("mouseover", function(node) {
               overCircle(node);
           })
           .on("mouseout", function(node) {
               outCircle(node);
           });

        // Transition nodes to their new position.
        var nodeUpdate = node.transition()
            .duration(duration)
            .attr("transform", function(d) {
                if(d.url === d.parent_url){
                    
                    return "translate(" + d.x + "," + (d.y - 40)  + ")";
                } else {
                    
                    return "translate(" + d.x + "," + d.y  + ")";
                }
            });

        // Fade the text in
        nodeUpdate.select("text")
            .style("fill-opacity", 1);

        // Transition exiting nodes to the parent's new position.
        var nodeExit = node.exit().transition()
            .duration(duration)
            .attr("transform", function(d) {
                return "translate(" + source.x + "," + source.y + ")";
            })
            .remove();

        nodeExit.select("circle")
            .attr("r", 0);

        nodeExit.select("text")
            .style("fill-opacity", 0);

        // Update the links…
        var link = svgGroup.selectAll("path.link")
            .data(links, function(d) {
                return d.target.id;
            });

        // Enter any new links at the parent's previous position.
        link.enter().insert("path", "g")
            .attr("class", "link")
            .attr("d", function(d) {
                var o = {
                    x: source.x0,
                    y: source.y0 
                };
                var diagonalData = diagonal({
                    source: o,
                    target: o
                });

                return diagonalData;
            });

        // Transition links to their new position.
        link.transition()
            .duration(duration)
            .attr("d", diagonal);

        // Transition exiting nodes to the parent's new position.
        link.exit().transition()
            .duration(duration)
            .attr("d", function(d) {
                var o = {
                    x: source.x,
                    y: source.y
                };
                var diagonalData = diagonal({
                    source: o,
                    target: o
                });
                return diagonalData;
            })
            .remove();

        // Stash the old positions for transition.
        nodes.forEach(function(d) {
            
            d.x0 = d.x;
            d.y0 = d.y;
        });
    }

    // Append a group which holds all nodes and which the zoom Listener can act upon.
    var svgGroup = baseSvg.append("g");

    // Define the root
    root = treeData.tree;
    root.x0 = viewerHeight / 2;
    root.y0 = 0;

    // Layout the tree initially and center on the root node.
    update(root);
    topNode(root);
}