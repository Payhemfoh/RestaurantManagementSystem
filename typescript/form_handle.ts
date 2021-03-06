export {validInput,inValidInput,showPasswordSetting};

/**
    This function is used to change the input bar status to indicate valid status
    @param inputElement The jQuery element of the input bar
    @param feedbackElement The jQuery element of the feedback block
*/
function validInput(inputElement : JQuery<HTMLElement>,feedbackElement : JQuery<HTMLElement>):void{
    if(inputElement.hasClass("is-invalid")){
        inputElement.removeClass("is-invalid");
    }

    if(!inputElement.hasClass("is-valid")){
        inputElement.addClass("is-valid");
    }

    if(feedbackElement.hasClass("invalid-feedback")){
        feedbackElement.removeClass("invalid-feedback");
    }

    if(!feedbackElement.hasClass("valid-feedback")){
        feedbackElement.addClass("valid-feedback");
    }

    feedbackElement.text("Looks Good!");
}

/**
    This function is used to change the input bar status to indicate invalid status
    @param inputElement The jQuery element of the input bar
    @param feedbackElement The jQuery element of the feedback block
    @param msg The message to be insert into the feedback block
*/
function inValidInput(inputElement : JQuery<HTMLElement>,feedbackElement : JQuery<HTMLElement>,msg : string):void{
    if(inputElement.hasClass("is-valid")){
        inputElement.removeClass("is-valid");
    }

    if(!inputElement.hasClass("is-invalid")){
        inputElement.addClass("is-invalid");
    }

    if(feedbackElement.hasClass("valid-feedback")){
        feedbackElement.removeClass("valid-feedback");
    }

    if(!feedbackElement.hasClass("invalid-feedback")){
        feedbackElement.addClass("invalid-feedback");
    }

    feedbackElement.text(msg);
}

function showPasswordSetting(inputElement : JQuery<HTMLElement>,conditionElement : JQuery<HTMLElement>){
    conditionElement.on("change",()=>{
        if(conditionElement.prop("checked")){
            inputElement.attr("type","text");
        }else{
            inputElement.attr("type","password");
        }
    });
}