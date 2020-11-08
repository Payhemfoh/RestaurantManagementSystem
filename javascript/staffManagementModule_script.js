import { inValidInput, showPasswordSetting, validInput } from "./form_handle.js";
import { errorModal } from "./errorFunction.js";
$(function () {
    $("#table").DataTable();
    //add new stock button
    setAddButton();
    setDeleteButton();
    setEditButton();
});
function setDeleteButton() {
    $(".btn_delete").on("click", function () {
        var id = this.getAttribute("value");
        $.ajax("../webpage/deleteStaff.php", {
            method: "post",
            dataType: "html",
            data: { id: id },
            success: function (data) {
                $("#modal-title").text("Delete Staff Data");
                $(".modal-body").html(data);
                $(".modal-footer").html("");
                $("#modal-submit").on("click", function (e) {
                    e.preventDefault();
                    $.ajax("../php/deleteStaff_process.php", {
                        method: "POST",
                        dataType: "HTML",
                        data: { id: id },
                        success: function (data) {
                            $("#modal-title").text("Staff Data Deleted");
                            $(".modal-body").html(data);
                            $(".modal-footer").html("");
                            $("#btnAgain").attr("data-dismiss", "modal");
                        },
                        error: errorModal
                    });
                });
                $("#modal-cancel").attr("data-dismiss", "modal");
                $("#modal").modal();
            },
            error: errorModal
        });
    });
}
function setAddButton() {
    $(".btn_add").on("click", function () {
        $.ajax("../webpage/addNewStaff.php", {
            method: "post",
            dataType: "HTML",
            success: function (data, status, xhr) {
                $("#modal-title").text("Add New Staff Data");
                $(".modal-body").html(data);
                $(".modal-footer").html("");
                showPasswordSetting($("#password"), $("#showpassword"));
                showPasswordSetting($("#confirm_password"), $("#showconfirmpassword"));
                $("#modal-submit").on("click", function (e) {
                    e.preventDefault();
                    var fname = $("#fname").val().trim();
                    var lname = $("#lname").val().trim();
                    var gender = $("input[name='gender']:checked").val();
                    var birthday = $("#birthday").val().trim();
                    var phone = $("#phone").val().trim();
                    var email = $("#email").val().trim();
                    var username = $("#username").val().trim();
                    var password = $("#password").val().trim();
                    var confirmPassword = $("#confirm_password").val().trim();
                    var position = $("#position").val();
                    var valid = true;
                    //validation
                    if (fname === "") {
                        inValidInput($("#fname"), $("#fname-feedback"), "First Name should not be empty!");
                        valid = false;
                    }
                    else {
                        validInput($("#fname"), $("#fname-feedback"));
                    }
                    if (lname === "") {
                        inValidInput($("#lname"), $("#lname-feedback"), "Last Name should not be empty!");
                        valid = false;
                    }
                    else {
                        validInput($("#lname"), $("#lname-feedback"));
                    }
                    if (gender == undefined) {
                        inValidInput($("#gender"), $("#gender-feedback"), "Gender should not be empty!");
                        valid = false;
                    }
                    else {
                        if (gender === "male") {
                            gender = 'M';
                            validInput($("#gender"), $("#gender-feedback"));
                        }
                        else if (gender === "female") {
                            gender = 'F';
                            validInput($("#gender"), $("#gender-feedback"));
                        }
                        else {
                            valid = false;
                            inValidInput($("#gender"), $("#gender-feedback"), "Invalid gender!");
                        }
                    }
                    if (birthday === "") {
                        inValidInput($("#birthday"), $("#birthday-feedback"), "Date Of Birth should not be empty!");
                        valid = false;
                    }
                    else {
                        validInput($("#birthday"), $("#birthday-feedback"));
                    }
                    if (phone === "") {
                        inValidInput($("#phone"), $("#phone-feedback"), "Phone No should not be empty!");
                        valid = false;
                    }
                    else {
                        validInput($("#phone"), $("#phone-feedback"));
                    }
                    if (email === "") {
                        inValidInput($("#email"), $("#email-feedback"), "Email should not be empty!");
                        valid = false;
                    }
                    else {
                        //the regex to check email format
                        if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email)) {
                            validInput($("#email"), $("#email-feedback"));
                        }
                        else {
                            inValidInput($("#email"), $("#email-feedback"), "The email format is Invalid!");
                            valid = false;
                        }
                    }
                    if (username === "") {
                        inValidInput($("#username"), $("#username-feedback"), "Username should not be empty!");
                        valid = false;
                    }
                    else {
                        validInput($("#username"), $("#username-feedback"));
                    }
                    if (password === "") {
                        inValidInput($("#password"), $("#password-feedback"), "Password should not be empty!");
                        valid = false;
                    }
                    else {
                        validInput($("#password"), $("#password-feedback"));
                    }
                    if (confirmPassword === "") {
                        inValidInput($("#confirm_password"), $("#confirmPassword-feedback"), "Confirm Password should not be empty!");
                        valid = false;
                    }
                    else {
                        if (confirmPassword === password) {
                            validInput($("#confirm_password"), $("#confirmPassword-feedback"));
                        }
                        else if (password === "") {
                            inValidInput($("#confirm_password"), $("#confirmPassword-feedback"), "Password is not filled!");
                            valid = false;
                        }
                        else {
                            inValidInput($("#confirm_password"), $("#confirmPassword-feedback"), "Password do not match the Confirm Password!");
                            valid = false;
                        }
                    }
                    if (valid) {
                        //post ajax call
                        $.ajax("../php/addNewStaff_process.php", {
                            method: "post",
                            dataType: "HTML",
                            data: {
                                fname: fname,
                                lname: lname,
                                gender: gender,
                                birthday: birthday,
                                phone: phone,
                                email: email,
                                username: username,
                                password: password,
                                confirmPassword: confirmPassword,
                                position: position
                            },
                            success: function (data) {
                                $("#modal-title").text("Add New Stock Data");
                                $(".modal-body").html(data);
                                $(".modal-footer").html("");
                            },
                            error: errorModal
                        });
                    }
                });
                $("#modal-cancel").attr("data-dismiss", "modal");
                $("#modal").modal();
            },
            error: errorModal
        });
    });
}
function setEditButton() {
    $(".btn_edit").on("click", function () {
        var id = this.getAttribute("value");
        $.ajax("../webpage/modifyStaff.php", {
            method: "post",
            dataType: "HTML",
            data: { id: id },
            success: function (data, status, xhr) {
                $("#modal-title").text("Modify Staff");
                $(".modal-body").html(data);
                $(".modal-footer").html("");
                showPasswordSetting($("#password"), $("#showpassword"));
                showPasswordSetting($("#newpassword"), $("#shownewpassword"));
                showPasswordSetting($("#confirm_password"), $("#showconfirmpassword"));
                $("#modal-cancel").attr("data-dismiss", "modal");
                $("#modal-submit").on("click", function (e) {
                    e.preventDefault();
                    //get user input
                    var fname = $("#fname").val().trim();
                    var lname = $("#lname").val().trim();
                    var gender = $("input[name='gender']:checked").val();
                    var birthday = $("#birthday").val().trim();
                    var phone = $("#phone").val().trim();
                    var email = $("#email").val().trim();
                    var username = $("#username").val().trim();
                    var password = $("#password").val().trim();
                    var newpassword = $("#newpassword").val().trim();
                    var confirm_password = $("#confirm_password").val().trim();
                    var position = $("#position").val();
                    var valid = true;
                    //validation
                    if (fname === "") {
                        inValidInput($("#fname"), $("#fname-feedback"), "First Name should not be empty!");
                        valid = false;
                    }
                    else {
                        validInput($("#fname"), $("#fname-feedback"));
                    }
                    if (lname === "") {
                        inValidInput($("#lname"), $("#lname-feedback"), "Last Name should not be empty!");
                        valid = false;
                    }
                    else {
                        validInput($("#lname"), $("#lname-feedback"));
                    }
                    if (gender == undefined) {
                        inValidInput($("#gender"), $("#gender-feedback"), "Gender should not be empty!");
                        valid = false;
                    }
                    else {
                        if (gender === "male") {
                            gender = 'M';
                            validInput($("#gender"), $("#gender-feedback"));
                        }
                        else if (gender === "female") {
                            gender = 'F';
                            validInput($("#gender"), $("#gender-feedback"));
                        }
                        else {
                            valid = false;
                            inValidInput($("#gender"), $("#gender-feedback"), "Invalid gender!");
                        }
                    }
                    if (birthday === "") {
                        inValidInput($("#birthday"), $("#birthday-feedback"), "Date Of Birth should not be empty!");
                        valid = false;
                    }
                    else {
                        validInput($("#birthday"), $("#birthday-feedback"));
                    }
                    if (phone === "") {
                        inValidInput($("#phone"), $("#phone-feedback"), "Phone No should not be empty!");
                        valid = false;
                    }
                    else {
                        validInput($("#phone"), $("#phone-feedback"));
                    }
                    if (email === "") {
                        inValidInput($("#email"), $("#email-feedback"), "Email should not be empty!");
                        valid = false;
                    }
                    else {
                        //the regex to check email format
                        if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email)) {
                            validInput($("#email"), $("#email-feedback"));
                        }
                        else {
                            inValidInput($("#email"), $("#email-feedback"), "The email format is Invalid!");
                            valid = false;
                        }
                    }
                    if (username === "") {
                        inValidInput($("#username"), $("#username-feedback"), "Username should not be empty!");
                        valid = false;
                    }
                    else {
                        validInput($("#username"), $("#username-feedback"));
                    }
                    if (password === "") {
                        inValidInput($("#password"), $("#password-feedback"), "Password should not be empty!");
                        valid = false;
                    }
                    else {
                        validInput($("#password"), $("#password-feedback"));
                    }
                    if (confirm_password === "") {
                        inValidInput($("#confirm_password"), $("#confirmPassword-feedback"), "Confirm Password should not be empty!");
                        valid = false;
                    }
                    else {
                        if (confirm_password === password) {
                            validInput($("#confirm_password"), $("#confirmPassword-feedback"));
                        }
                        else if (password === "") {
                            inValidInput($("#confirm_password"), $("#confirmPassword-feedback"), "Password is not filled!");
                            valid = false;
                        }
                        else {
                            inValidInput($("#confirm_password"), $("#confirmPassword-feedback"), "Password do not match the Confirm Password!");
                            valid = false;
                        }
                    }
                    $.ajax("../php/updateStaff_process.php", {
                        method: "POST",
                        dataType: "HTML",
                        data: {
                            fname: fname,
                            lname: lname,
                            gender: gender,
                            birthday: birthday,
                            phone: phone,
                            email: email,
                            username: username,
                            password: password,
                            newpassword: newpassword,
                            confirm_password: confirm_password,
                            position: position
                        },
                        success: function (data, status, xhr) {
                            $("#modal-title").text("Modify Staff");
                            $(".modal-body").html(data);
                            $(".modal-footer").html("");
                        },
                        error: errorModal
                    });
                });
                $("#modal").modal();
            },
            error: errorModal
        });
    });
}