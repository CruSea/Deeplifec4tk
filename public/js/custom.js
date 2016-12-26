
$(document).ready(function(){
    answers = new Array();
    var flagSave=1;
    var item1 = document.getElementById('questions');
    var totalQuestions = $('.questions').size();
    $questions = $('.questions');
    $comments = $('.notes');
    $questions.hide();
    $($questions.get(currentQuestion)).fadeIn();
    $($comments.get(currentQuestion)).fadeIn();
    if(currentQuestion == 0) {
        $('.previous').fadeOut();
    }
    if(currentQuestion == totalQuestions - 1) {
        $('.next').fadeOut();
    }
    $('.previous').click(function(){
        updateQuestionScreen(false);
    });
    $('.next').click(function(){
        updateQuestionScreen(true);
    });
    function updateQuestionScreen(isNext) {
        $($questions.get(currentQuestion)).hide();
        $($comments.get(currentQuestion)).hide();
        var questionid=$($questions.get(currentQuestion)).find("input[name*='question']").val();
        var mandatory =$($questions.get(currentQuestion)).find("input[name*='mandatory']").val();
        var radioInline=$($questions.get(currentQuestion)).find("input[name*='radioInline']:checked").val();
        var numberInline=$($questions.get(currentQuestion)).find("input[name*='numberInline']").val();
        var notes=$($questions.get(currentQuestion)).find("textarea[name*='notes']").val();
        var country=$($questions.get(currentQuestion)).find("input[name*='country']").val();
        var stage=$($questions.get(currentQuestion)).find("input[name*='stage']").val();
        var userid=$($questions.get(currentQuestion)).find("input[name*='userid']").val();
        if(radioInline === undefined) {
            radioInline = '';
        }
        if(numberInline === undefined) {
            numberInline  = 0;
        }
        answers[currentQuestion] = questionid+'#'+radioInline+'#'+numberInline+'#'+notes+'#'+country+'#'+stage+'#'+userid;
        if(mandatory==1 && (radioInline==0 && numberInline == 0) && flagSave==1  ){
            flagSave=0;
        }
        if(currentQuestion == 1 && !isNext){
            $('.previous').hide();
            $('.next').fadeIn();
        } else if(currentQuestion == totalQuestions - 2 && isNext){
            $('.next').hide();
            $('.previous').fadeIn();
        } else {
            $('.next').fadeIn();
            $('.previous').fadeIn();
        }
        if(isNext) {
            currentQuestion++;
        } else {
            currentQuestion--;
        }
        if(currentQuestion == totalQuestions){
            $('.counter').hide();
            $.ajax({
                url: "/movement/localbuild",
                data: {answersdata: answers,flagsave: flagSave},
                type: 'post',
                success: function(output) {
                   if(output==1){
                      $('#result').show();
                   } else {
                       $('#stageresult').show();
                   }
                }
            });
        } else {
            $($questions.get(currentQuestion)).fadeIn();
            $($comments.get(currentQuestion)).fadeIn();
            $('#counter').text(currentQuestion+1);
        }
    }
    $('.save').click(function(){
        var questionid=$($questions.get(currentQuestion)).find("input[name*='question']").val();
        var mandatory =$($questions.get(currentQuestion)).find("input[name*='mandatory']").val();
        var radioInline=$($questions.get(currentQuestion)).find("input[name*='radioInline']:checked").val();
        var numberInline=$($questions.get(currentQuestion)).find("input[name*='numberInline']").val();
        var notes=$($questions.get(currentQuestion)).find("textarea[name*='notes']").val();
        var country=$($questions.get(currentQuestion)).find("input[name*='country']").val();
        var stage=$($questions.get(currentQuestion)).find("input[name*='stage']").val();
        var userid=$($questions.get(currentQuestion)).find("input[name*='userid']").val();
        if(radioInline === undefined) {
            radioInline = '';
        }
        if(numberInline === undefined) {
            numberInline  = 0;
        }
        answerstring = questionid+'#'+radioInline+'#'+numberInline+'#'+notes+'#'+country+'#'+stage+'#'+userid;
        $.ajax({
            url: "/movement/savenotes",
            data: {answerdata: answerstring},
            type: 'post',
            success: function(output) {
               if(output!=0){
                    $table = $comments.get(currentQuestion);
                    row = $(output);
                    row.prependTo($table);
                    $($questions.get(currentQuestion)).find("textarea[name*='notes']").val('');
               } else {
                   $('#stageresult').show();
               }
            }
        });
    });
    /*TOOLTIP*/
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});