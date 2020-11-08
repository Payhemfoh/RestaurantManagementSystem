import { errorModal } from "./errorFunction.js";
import { inValidInput, validInput } from "./form_handle.js";

function readUrl(input : HTMLInputElement){
    if(input.files && input.files[0]){
        let reader = new FileReader();
        reader.onload = (e) =>{
            let imgData = (e.target)!.result;
            let imgName = (input.files)![0].name;
            input.setAttribute("data-title",imgName);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(function(){
    ($("#table") as any).DataTable();

    //add new stock button
    $(".btn_add").on("click",function(){
        $.ajax("../webpage/addNewMenu.php",{
            method:"post",
            dataType:"HTML",
            success:function(data,status,xhr){
                $("#modal-title").text("Add New Menu Data");
                $(".modal-body").html(data);
                $(".modal-footer").html("");

                $("#modal-submit").on("click",function(e){
                    e.preventDefault();

                    let valid = false;
                    /*
                    //get user input
                    let name = $("#name_input").val();
                    let quantity = ($("#quantity_input").val()) as number;
                    let description = $("#description_input").val();
                    

                    //validation
                    if(name === ""){
                        inValidInput($("#name_input"),$("#name-feedback"),"The name should not be empty!");
                        valid = false;
                    }else{
                        validInput($("#name_input"),$("#name-feedback"));
                    }

                    if(quantity<0){
                        inValidInput($("#quantity_input"),$("#quantity-feedback"),"The quantity should not below 0!");
                        valid = false;
                    }else{
                        validInput($("#quantity_input"),$("#quantity-feedback"));
                    }

                    if(description === ""){
                        inValidInput($("#description_input"),$("#description-feedback"),"The description should not be empty!");
                        valid = false;
                    }else{
                        validInput($("#description_input"),$("#description-feedback"));
                    }
                    */

                    if(valid){
                        //post ajax call
                        $.ajax("../php/addNewMenu_process.php",{
                            method:"post",
                            dataType:"HTML",
                            data:{
                            },
                            success:function(data){
                                $("#modal-title").text("Add New Stock Data");
                                $(".modal-body").html(data);

                                $("#dropzone").on("change",()=>readUrl(this));
                                
                                $(".modal-footer").html("");
                            },
                            error:errorModal
                        })
                    }
                });
                $("#modal-cancel").attr("data-dismiss","modal");

                ($("#modal") as any).modal();
            },
            error:errorModal

        });
    });

    $(".btn_delete").on("click",function(){
        let id = this.getAttribute("value");

        $.ajax("../webpage/deleteMenu.php",{
            method:"post",
            dataType:"html",
            data:{id:id},
            success:(data)=>{
                $("#modal-title").text("Delete Menu Data");
                $(".modal-body").html(data);
                $(".modal-footer").html("");
                $("#modal-submit").on("click",(e)=>{
                    e.preventDefault();
                    $.ajax("../php/deleteMenu_process.php",{
                        method:"POST",
                        dataType:"HTML",
                        data:{id:id},
                        success:(data)=>{
                            $("#modal-title").text("Menu Data Deleted");
                            $(".modal-body").html(data);
                            $(".modal-footer").html("");
                            $("#btnAgain").attr("data-dismiss","modal");
                        },
                        error:errorModal
                    });
                })
                $("#modal-cancel").attr("data-dismiss","modal");

                ($("#modal") as any).modal();
            },
            error:errorModal
        });
    });


    $(".btn_edit").on("click",function(){
        let id = this.getAttribute("value");

        $.ajax("../webpage/modifyMenu.php",{
            method:"post",
            dataType:"HTML",
            data:{id:id},
            success:function(data,status,xhr){
                $("#modal-title").text("Modify Menu");
                $(".modal-body").html(data);

                $(".modal-footer").html("");

                $("#modal-cancel").attr("data-dismiss","modal");
                $("#modal-submit").on("click",function(e){
                    e.preventDefault();

                    let name="";
                    let price = "";
                    let description = "";
                    let picture = "";
                    let category = "";

                    $.ajax("../php/updateMenu_process.php",{
                        method:"POST",
                        dataType:"HTML",
                        data:{
                            name:name,
                            price:price,
                            description:description,
                            category:category,
                            newImg:picture
                        },
                        success:function(data,status,xhr){
                            $("#modal-title").text("Modify Menu");
                            $(".modal-body").html(data);
                            $(".modal-footer").html("");
                        },
                        error:errorModal
                    });
                });
                ($("#modal") as any).modal();
            },
            error:errorModal
        });
    })
});