$(document).ready(function(){
answers =new  Array();
var flagSave=1;
var item1 = document.getElementById('questions');
var totalQuestions = $('.questions').size();
var currentQuestion = 0;
$questions = $('.questions');
$questions.hide();
$($questions.get(currentQuestion)).fadeIn();
$('.next').click(function(){
    $($questions.get(currentQuestion)).fadeOut(function(){
   var questionid=$($questions.get(currentQuestion)).find("input[name*='question']").val();
  var mandatory =$($questions.get(currentQuestion)).find("input[name*='mandatory']").val();
 var radioInline=$($questions.get(currentQuestion)).find("input[name*='radioInline']:checked").val();
 var country=$($questions.get(currentQuestion)).find("input[name*='country']").val();
 var stage=$($questions.get(currentQuestion)).find("input[name*='stage']").val();
 var userid=$($questions.get(currentQuestion)).find("input[name*='userid']").val();
 
 
 answers.push(questionid+'#'+radioInline+'#'+country+'#'+stage+'#'+userid);
   if(mandatory==1 && radioInline==0 && flagSave==1  ){
        flagSave=0;
    }
      
        currentQuestion = currentQuestion + 1;
               if(currentQuestion == totalQuestions){
               $('.counter').hide();
                   $.ajax({
             url: "/movement/localbuild",
             data: {answersdata: answers,flagsave: flagSave},
             type: 'post',
             success: function(output) {
                    $('#result').show();
                   
                      }
                    }); 
        
      
        }else{
        $($questions.get(currentQuestion)).fadeIn();
        $('#counter').text(currentQuestion+1);
        }
    });

});
});
 /*TOOLTIP*/
 $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


 /*Bootstrap Datetimepicker*/
 $(function () {
        $('#datetimepicker1').datetimepicker({
              format: 'MMM DD YYYY',
              minDate:new Date(),
        });
        $('#datetimepicker2').datetimepicker({
                    format: 'LT'
                });
            });