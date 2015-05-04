//$(document).ready(function() {
var ArrayOfEmployees = [];
var gCustomers = [];
var AskMessage = [];
var FullCustomerTransaction = [];
var FullCustomertoCustomerTransaction = [];
var loggedInCustomer = null;
var loggedInUser = null;
//if empty
//

if (!localStorage.Page) {
    LoggedInCustomer = '[]';
    $('#HomePageAll').css('display', 'inline-block');
    $('#' + localStorage.Nav).css('display', 'none');
}
else {
    $('#' + localStorage.Page).css('display', 'block');
    $('#' + localStorage.Nav).css('display', 'block');
    $('#HomePageAll').css('display', 'none');
}

if (!localStorage.LoggedInUser) {
    LoggedInUser = '[]';
}
else {
    loggedInUser = JSON.parse(localStorage.LoggedInUser);
    $('#employeeNav').css('display', 'block');
    $('.employeeLogin').css('display', 'none');
    $("#LblName").html('<span>Welcome</span> ' + loggedInUser.name + '');
    $('#BtnDropdown').css('display', 'none');
    $('#Log-Off').css('display', 'inline-block');
    loggedInUser = JSON.parse(localStorage.LoggedInUser);
}

if (!localStorage.LoggedInCustomer) {
    LoggedInCustomer = '[]';
}
else {
    loggedInCustomer = JSON.parse(localStorage.LoggedInCustomer);
    $('#customerNav').css('display', 'block');
    $("#LblName").html('<span>Welcome ' + loggedInCustomer.name + ' ' + loggedInCustomer.Lastname + '</span><span> - Balance: </span><span class="ClassAmount">' + loggedInCustomer.amount + ' Kr.</span>');
    $('#BtnDropdown').css('display', 'none');
    $('#Log-Off').css('display', 'inline-block');
    $("#TableRowsUser").html('<tr><td>' + loggedInCustomer.BA + '</td><td>' + loggedInCustomer.name + '</td><td>' + loggedInCustomer.Lastname + '</td><td>' + loggedInCustomer.phone + '</td><td>' + loggedInCustomer.cpr + '</td><td>' + loggedInCustomer.gender + '</td><td id="UserAmount">' + loggedInCustomer.amount + '</td></tr>');
    $('#AskFirstName').val(loggedInCustomer.name);
    for (var p = 0; p < FullCustomerTransaction.length; p++)
    {
        if (loggedInCustomer.name == FullCustomerTransaction[p].TransactionFrom) {


            $("#TableRowsTransactions").append('<tr><td>' + FullCustomerTransaction[p].Time + '</td><td>' + FullCustomerTransaction[p].TransactionTo + '</td><td>' + FullCustomerTransaction[p].TransactionAmount + '</td><td class="PendingAnsw">' + FullCustomerTransaction[p].pending + '</td></tr>');
        }
    }

    if (loggedInCustomer.amount >= 0) {
        $('.ClassAmount').css('background-color', 'green');
    }
    else {
        $('.ClassAmount').css('background-color', 'red');
        $('.ClassAmount').html(loggedInCustomer.amount + '<span> You are en big trouble  </span>');
    }
    loggedInCustomer = JSON.parse(localStorage.LoggedInCustomer);
}

if (!localStorage.Transactions) {
    localStorage.Transactions = '[]';
}
else {
    FullCustomerTransaction = JSON.parse(localStorage.Transactions);
}
if (!localStorage.TransactionsEmployeeMade) {
    localStorage.TransactionsEmployeeMade = '[]';
}
else {
    FullCustomertoCustomerTransaction = JSON.parse(localStorage.TransactionsEmployeeMade);
}

//Hardcodet employees/Customers 
if (!localStorage.Employees) {
    localStorage.Employees = '[]';
    var sEmployeeOne = {"name": "Admin", "pass": 'pass'};
    var sEmployeeTwo = {"name": "Peter", "pass": 'pass'};
    var sEmployeeThree = {"name": "Marky", "pass": 'pass'};
    ArrayOfEmployees.push(sEmployeeOne, sEmployeeTwo, sEmployeeThree);
    localStorage.Employees = JSON.stringify(ArrayOfEmployees);
}
else {
    ArrayOfEmployees = JSON.parse(localStorage.Employees);
}

if (!localStorage.Customers) {
    localStorage.Customers = '[]';
    var Customer1 = {"name": "John", "Lastname": "Nielsen", "phone": 11111111, "pass": 123, "cpr": 123, "amount": 1000, "BA": 1234, "gender": 'male', "maxAmount": 5000};
    var Customer2 = {"name": "Peter", "Lastname": "Nielsen", "phone": 22222222, "pass": 123, "cpr": 456, "amount": 500, "BA": 4321, "gender": 'male', "maxAmount": 5000};
    var Customer3 = {"name": "Fie", "Lastname": "Nielsen", "phone": 33333333, "pass": 123, "cpr": 789, "amount": 100, "BA": 1661, "gender": 'female', "maxAmount": 5000};
    gCustomers.push(Customer1, Customer2, Customer3);
    localStorage.Customers = JSON.stringify(gCustomers);
}
else {
    gCustomers = JSON.parse(localStorage.Customers);
}

if (!localStorage.Message) {
    localStorage.Message = '[]';
}
//PREVENT LINK TO REFRESH PAGE


//Clear Storage
$(document).on("click", "#ClearLocalStorage", function() {
    localStorage.clear();
    location.reload();
});

//Show hide pages/sections
$(document).on("click", ".MyLink", function() {
    $(".EmployeePage, .CustomerPage").css("display", "none");
    var sText = $(this).attr("data-link");
    localStorage.Page = $(this).attr("data-link");
    $('*[data-page="' + sText + '"]').fadeIn("slow");
});

//Show hide Logins - Mobile fix
function ChangeOne() {
    $('.customerLogin').css('display', 'block');
    $('.employeeLogin').css('display', 'none');
}

function ChangeTwo() {
    $('.employeeLogin').css('display', 'block');
    $('.customerLogin').css('display', 'none');
}

//Login Function Employee
$(document).on("click", "#EmployeeLoginBtn", function() {
    $('#customerNav').css('display', 'none');

    var sLoginName = $("#TxtLoginNameEmployee").val();
    var sLoginPass = $("#TxtLoginPassEmployee").val();
    $("#TxtLoginPassEmployee").val('');
    $("#TxtLoginNameEmployee").val('');

    for (var i = 0; i < ArrayOfEmployees.length; i++) {

        var sName = ArrayOfEmployees[i].name;
        var sPass = ArrayOfEmployees[i].pass;

        if (sLoginName == sName && sLoginPass == sPass) {
            $('#employeeNav').css('display', 'block');
            $('.employeeLogin').css('display', 'none');
            $("#LblName").html('<span>Welcome</span> ' + ArrayOfEmployees[i].name + '');
            loggedInUser = ArrayOfEmployees[i];
            $('#BtnDropdown').css('display', 'none');
            $('#Log-Off').css('display', 'inline-block');
            localStorage.LoggedInUser = JSON.stringify(loggedInUser);
            localStorage.Nav = "employeeNav";
        }
        else {
            $(".toggle").effect("shake");
        }
    }
});

//Login Function Customers
$(document).on("click", "#CustomerLoginBtn", function() {
    $('#employeeNav').css('display', 'none');

    var sLoginName = $("#TxtLoginNameCustomer").val();
    var sLoginPass = $("#TxtLoginPassCustomer").val();
    $("#TxtLoginPassCustomer").val('');
    $("#TxtLoginNameCustomer").val('');

    for (var i = 0; i < gCustomers.length; i++) {

        var sName = gCustomers[i].name;
        var sPass = gCustomers[i].pass;

        if (sLoginName == sName && sLoginPass == sPass) {
            $('#customerNav').css('display', 'block');
            $('.customerLogin').css('display', 'none');
            $("#LblName").html('<span>Welcome ' + gCustomers[i].name + ' ' + gCustomers[i].Lastname + '</span><span> - Balance: </span><span class="ClassAmount">' + gCustomers[i].amount + ' Kr.</span>');
            $("#TableRowsUser").html('<tr><td>' + gCustomers[i].BA + '</td><td>' + gCustomers[i].name + '</td><td>' + gCustomers[i].Lastname + '</td><td>' + gCustomers[i].phone + '</td><td>' + gCustomers[i].cpr + '</td><td>' + gCustomers[i].gender + '</td><td id="UserAmount">' + gCustomers[i].amount + '</td></tr>');
            loggedInCustomer = gCustomers[i];
            $('#AskFirstName').val(loggedInCustomer.name);
            $('#BtnDropdown').css('display', 'none');
            $('#Log-Off').css('display', 'inline-block');
            $("#TableRowsTransactions").empty();
            localStorage.LoggedInCustomer = JSON.stringify(loggedInCustomer);
            localStorage.Page = "HomePageAll";
            localStorage.Nav = "customerNav";
            //Append LoggedInCustomer Transactions
            for (var p = 0; p < FullCustomerTransaction.length; p++)
            {
                if (gCustomers[i].name == FullCustomerTransaction[p].TransactionFrom) {


                    $("#TableRowsTransactions").append('<tr><td>' + FullCustomerTransaction[p].Time + '</td><td>' + FullCustomerTransaction[p].TransactionTo + '</td><td>' + FullCustomerTransaction[p].TransactionAmount + '</td><td class="PendingAnsw">' + FullCustomerTransaction[p].pending + '</td></tr>');
                }
            }

            if (gCustomers[i].amount >= 0) {
                $('.ClassAmount').css('background-color', 'green');
            }
            else {
                $('.ClassAmount').css('background-color', 'red');
                $('.ClassAmount').html(gCustomers[i].amount + '<span> You are en big trouble  </span>');
            }
        }
        else {
            $(".toggle").effect("shake");
        }
    }
});

//Log-off BTN
$(document).on("click", "#Log-Off", function() {
    loggedInCustomer = null;
    loggedInUser = null;
    localStorage.removeItem('LoggedInCustomer');
    localStorage.removeItem('LoggedInUser');
    localStorage.removeItem('Nav');
    localStorage.removeItem('Page');
    $("#LblName").html('');
    $('#customerNav').css('display', 'none');
    $('#employeeNav').css('display', 'none');
    $('#BtnDropdown').css('display', 'inline-block');
    $('#Log-Off').css('display', 'none');
    $(".EmployeePage, .CustomerPage").css({"display": "none"});
    $('#HomePageAll').css('display', 'inline-block');
});

//Add Employee
$(document).on("click", "#BtnSaveToStorage", function() {

    var sFirstName = $("#TxtFirstName").val();
    var sPass = $("#TxtPass").val();

    $("#TxtFirstName").val("");
    $("#TxtPass").val("");

    var EmployeeInfo = {"name": sFirstName, "pass": sPass};
    ArrayOfEmployees.push(EmployeeInfo);
    localStorage.Employees = JSON.stringify(ArrayOfEmployees);
});

//Add Customer
$(document).on("click", "#BtnSaveCustomer", function() {
    var sCustomerBA = $("#TxtCustomerBA").val();
    var sCustomerFirstName = $("#TxtCustomerName").val();
    var sCustomerLastName = $("#TxtCustomerLastName").val();
    var sCustomerCpr = $("#TxtCustomerCpr").val();
    var sCustomerPhone = $("#TxtCustomerPhone").val();
    var sCustomerAmount = $("#TxtCustomerAmount").val();
    var sCustomerGender = $("#TxtCustomerGender option:selected").val();
    var sCustomerPass = $("#TxtCustomerPass").val();

    $("#TxtCustomerBA").val("");
    $("#TxtCustomerName").val("");
    $("#TxtCustomerLastName").val("");
    $("#TxtCustomerCpr").val("");
    $("#TxtCustomerPhone").val("");
    $("#TxtCustomerAmount").val("");
    $("#TxtCustomerGender").val("");
    $("#TxtCustomerPass").val("");

    var CustomerInfo = {"name": sCustomerFirstName, "Lastname": sCustomerLastName, "phone": sCustomerPhone, "pass": sCustomerPass, "cpr": sCustomerCpr, "amount": sCustomerAmount, "BA": sCustomerBA, "gender": sCustomerGender};
    gCustomers.push(CustomerInfo);

    localStorage.Customers = JSON.stringify(gCustomers);
});

//Customer statistics
var theClass = "";
var CounterFemale = 0;
var CounterMale = 0;
var PoorNr = 0;
var MiddleNr = 0;
var RichNr = 0;
for (var i = 0; i < gCustomers.length; i++) {
    if (gCustomers[i].amount <= 100) {
        theClass = "danger";
        $("#TableRowsPoor").append('<tr id="BA' + gCustomers[i].BA + '" class="Modalpopup ' + theClass + '"><td>' + gCustomers[i].BA + '</td><td>' + gCustomers[i].name + '</td><td>' + gCustomers[i].Lastname + '</td><td>' + gCustomers[i].phone + '</td><td>' + gCustomers[i].cpr + '</td><td>' + gCustomers[i].gender + '</td><td>' + gCustomers[i].amount + '</td></tr>');
        var PoorName = gCustomers[i].name;
        var PoorCus = parseInt(gCustomers[i].amount);
        PoorNr++;
    }
    if (gCustomers[i].amount > 100 && gCustomers[i].amount < 1000) {
        theClass = "warning";
        $("#TableRowsMiddle").append('<tr id="BA' + gCustomers[i].BA + '" class="Modalpopup ' + theClass + '"><td>' + gCustomers[i].BA + '</td><td>' + gCustomers[i].name + '</td><td>' + gCustomers[i].Lastname + '</td><td>' + gCustomers[i].phone + '</td><td>' + gCustomers[i].cpr + '</td><td>' + gCustomers[i].gender + '</td><td>' + gCustomers[i].amount + '</td></tr>');
        var MiddleCus = parseInt(gCustomers[i].amount);
        var MiddleName = gCustomers[i].name;
        MiddleNr++;
    }
    if (gCustomers[i].amount >= 1000) {
        theClass = "success";
        $("#TableRowsRich").append('<tr id="BA' + gCustomers[i].BA + '" class="Modalpopup ' + theClass + '"><td>' + gCustomers[i].BA + '</td><td>' + gCustomers[i].name + '</td><td>' + gCustomers[i].Lastname + '</td><td>' + gCustomers[i].phone + '</td><td>' + gCustomers[i].cpr + '</td><td>' + gCustomers[i].gender + '</td><td>' + gCustomers[i].amount + '</td></tr>');
        var RichCus = parseInt(gCustomers[i].amount);
        var RichName = gCustomers[i].name;
        RichNr++;


    }
    if (gCustomers[i].gender == 'male') {
        $("#maleCustomers").append('<tr class="' + theClass + '"><td>' + gCustomers[i].BA + '</td><td>' + gCustomers[i].name + '</td><td>' + gCustomers[i].Lastname + '</td><td>' + gCustomers[i].phone + '</td><td>' + gCustomers[i].cpr + '</td><td>' + gCustomers[i].gender + '</td><td>' + gCustomers[i].amount + '</td></tr>');
        var MaleAmount = gCustomers[i].amount;
        var MaleNr = gCustomers[i].gender;
        CounterMale++;
    }
    if (gCustomers[i].gender == 'female') {
        $("#femaleCustomers").append('<tr class="' + theClass + '"><td>' + gCustomers[i].BA + '</td><td>' + gCustomers[i].name + '</td><td>' + gCustomers[i].Lastname + '</td><td>' + gCustomers[i].phone + '</td><td>' + gCustomers[i].cpr + '</td><td>' + gCustomers[i].gender + '</td><td>' + gCustomers[i].amount + '</td></tr>');
        var FemaleAmount = parseInt(gCustomers[i].amount);
        var FemaleNr = gCustomers[i].gender;
        CounterFemale++;
    }

    $("#SearchInput, #SearchInputCustomerOne, #SearchInputCustomerTwo").append('<option id="' + gCustomers[i].BA + '">' + gCustomers[i].name + '</option>');
}
$("#chartContainer").append('<img src="https://chart.googleapis.com/chart?chf=bg,s,00000000&chs=400x180&chd=t:' + PoorNr + ',' + MiddleNr + ',' + RichNr + '&cht=p3&chl=Poor|Middle|Rich&chco=f2dede|fcf8e3|dff0d8" alt="Image test" title="Image test" /><span>Rich, Middle and Poor chart</span>');
$("#chartContainerGender").append('<img src="https://chart.googleapis.com/chart?chf=bg,s,00000000&chs=400x180&chd=t:' + CounterFemale + ',' + CounterMale + '&cht=p3&chl=Female|Male&chco=ffffff|000000" alt="Image test" title="Image test" /><span>Gender ratio chart</span>');
//Customer Transfer money
$(document).on("click", "#Transfer", function() {
    var now = new Date();
    var sTheAmount = parseInt($("#AmountNumber").val());
    var SelectedCustomerId = $("#SearchInput option:selected").attr('id');
    console.log(loggedInCustomer.maxAmount);
    for (var i = 0; i < gCustomers.length; i++) {
        if (gCustomers[i].BA == SelectedCustomerId && sTheAmount < 1000) {
            gCustomers[i].amount += sTheAmount;
            var ReceiverName = gCustomers[i].name;
            var Pending = "no";
            $("#ReceiptNameReplace").html('<span>Receiver: ' + ReceiverName + ' </span>');
            $("#ReceiptAmount").html('<span>$ Amount: </span>' + sTheAmount + '<span> Kr.</span>');
            $("#PaperReceipt").slideDown(1000);
            $(".moneyImg").delay(100).slideDown(1000);
        }
        if (gCustomers[i].BA == SelectedCustomerId && sTheAmount >= 1000) {
            var ReceiverName = gCustomers[i].name;
            var Pending = "Yes";
            $("#ReceiptNameReplace").html('<div>You are trying to transfer more than 1000 kr. </div><div>Pending transaction to: ' + ReceiverName + ' </div>');
            $("#ReceiptAmount").html('<span>$ Amount: </span>' + sTheAmount + '<span> Kr.</span>');
            $("#PaperReceipt").slideDown(1000);
            $("#PaperReceipt").css('background-color', 'red');
            $('#ReceiptNameReplace, #ReceiptAmount').css('top', '0px');
            $("#TableRowsPending").append('<tr><td>' + loggedInCustomer.name + '</td><td>' + ReceiverName + '</td><td>' + sTheAmount + '</td><td>' + Pending + '</td></tr>');
        }
    }
    loggedInCustomer.amount -= sTheAmount;
    loggedInCustomer.maxAmount -= sTheAmount;
    $("#UserAmount").html(loggedInCustomer.amount);
    $(".ClassAmount").html(loggedInCustomer.amount);
    $(".ClassmaxAmount").html(loggedInCustomer.maxAmount);

    //Customer transactions
    var oCustomerTransaction = {"Time": now, "TransactionFrom": loggedInCustomer.name, "TransactionTo": ReceiverName, "TransactionAmount": sTheAmount, "pending": Pending};
    FullCustomerTransaction.push(oCustomerTransaction);
    localStorage.Transactions = JSON.stringify(FullCustomerTransaction);

    localStorage.Customers = JSON.stringify(gCustomers);

    $("#TableRowsTransactions").append('<tr><td>' + now + '</td><td>' + oCustomerTransaction.TransactionTo + '</td><td>' + oCustomerTransaction.TransactionAmount + '</td><td class="PendingAnsw">' + oCustomerTransaction.pending + '</td></tr>');

    if (Pending == 'no') {
        $("#TransactionHistoryCustomer").append('<tr><td>' + oCustomerTransaction.TransactionFrom + '</td><td>' + oCustomerTransaction.TransactionTo + '</td><td>' + sTheAmount + '</td></tr>');
    }
});

//Append LoggedInCustomer Transactions
for (var i = 0; i < FullCustomerTransaction.length; i++) {
    $("#TableRowsTransactions").append('<tr><td>' + FullCustomerTransaction[i].Time + '</td><td>' + FullCustomerTransaction[i].TransactionTo + '</td><td>' + FullCustomerTransaction[i].TransactionAmount + '</td><td class="PendingAnsw">' + FullCustomerTransaction[i].pending + '</td></tr>');
}

//Append Pending
for (var i = 0; i < FullCustomerTransaction.length; i++) {
    if (FullCustomerTransaction[i].TransactionAmount >= 1000 && FullCustomerTransaction[i].pending == 'Yes') {
        $("#TableRowsPending").append('<tr><td>' + FullCustomerTransaction[i].TransactionFrom + '</td><td>' + FullCustomerTransaction[i].TransactionTo + '</td><td>' + FullCustomerTransaction[i].TransactionAmount + '</td><td>' + FullCustomerTransaction[i].pending + '</td></tr>');
    }
}

//Accept Pending
$(document).on("click", "#AnswerPending", function() {
    for (var p = 0; p < FullCustomerTransaction.length; p++) {
        if (FullCustomerTransaction[p].pending == "Yes") {
            for (var i = 0; i < gCustomers.length; i++) {
                if (gCustomers[i].name == FullCustomerTransaction[p].TransactionTo) {
                    gCustomers[i].amount += FullCustomerTransaction[p].TransactionAmount;
                    FullCustomerTransaction[p].pending = "no";
                }
            }
            $("#TransactionHistoryCustomer").append('<tr><td>' + FullCustomerTransaction[p].TransactionFrom + '</td><td>' + FullCustomerTransaction[p].TransactionTo + '</td><td>' + FullCustomerTransaction[p].TransactionAmount + '</td></tr>');
        }
    }
    $('.PendingAnsw').text('no');
    $("#TableRowsPending").html('');
    localStorage.Transactions = JSON.stringify(FullCustomerTransaction);
    localStorage.Customers = JSON.stringify(gCustomers);
});

//Employee transfer money between customers
$(document).on("click", "#TransferBetweenCustomers", function() {
    var sTheAmount = parseInt($("#CustomerAmountNumber").val());
    $("#ReceiptAmountCustomer").html('<span>$ Amount: </span>' + sTheAmount + '<span> Kr.</span>');
    $("#PaperReceiptCustomertoCustomer").slideDown(1000);
    $(".moneyImg2").delay(100).slideDown(1000);
    var SelectedCustomerIdOne = $("#SearchInputCustomerOne option:selected").attr('id');
    var SelectedCustomerIdTwo = $("#SearchInputCustomerTwo option:selected").attr('id');

    for (var i = 0; i < gCustomers.length; i++) {
        if (gCustomers[i].BA == SelectedCustomerIdOne) {
            var SenderOne = gCustomers[i].name;
            gCustomers[i].amount -= sTheAmount;
        }
        if (gCustomers[i].BA == SelectedCustomerIdTwo) {
            var SenderTwo = gCustomers[i].name;
            gCustomers[i].amount += sTheAmount;
        }
    }

    var oCustomerToCustomerTransaction = {"TransactionFrom": SenderOne, "TransactionTo": SenderTwo, "TransactionAmount": sTheAmount};
    FullCustomertoCustomerTransaction.push(oCustomerToCustomerTransaction);
    localStorage.TransactionsEmployeeMade = JSON.stringify(FullCustomertoCustomerTransaction);

    $("#ReceiptNameCustomerOne").html('<span>From Customer: </span>' + SenderOne + '');
    $("#ReceiptNameCustomerTwo").html('<span>To Customer: </span>' + SenderTwo + '');
    $("#TransactionHistory").append('<tr><td>' + SenderOne + '</td><td>' + SenderTwo + '</td><td>' + sTheAmount + '</td></tr>');
    localStorage.Customers = JSON.stringify(gCustomers);
});

//Customer transaction modal
$(document).on("click", ".Modalpopup", function() {
    $('.Trans-modal').modal('show');
    var id = $(this).attr("id");
    var name = $(this).find('td:eq(1)').text();
    console.log(name);
    $("#TransactionHistoryCustomer").empty();
//    id.substring(2, 6);
    for (var i = 0; i < FullCustomerTransaction.length; i++) {
        if (name == FullCustomerTransaction[i].TransactionTo || name == FullCustomerTransaction[i].TransactionFrom) {
            $("#TransactionHistoryCustomer").append('<tr><td>' + FullCustomerTransaction[i].TransactionFrom + '</td><td>' + FullCustomerTransaction[i].TransactionTo + '</td><td>' + FullCustomerTransaction[i].TransactionAmount + '</td></tr>');
        }
    }
//    console.log(id.substring(2, 6));
});

//Append transaction history Customer transactions
//for (var i = 0; i < FullCustomerTransaction.length; i++) {
//    var PendingAnswer = FullCustomerTransaction[i].pending;
//    if (PendingAnswer == 'no') {
//        $("#TransactionHistoryCustomer").append('<tr><td>' + FullCustomerTransaction[i].TransactionFrom + '</td><td>' + FullCustomerTransaction[i].TransactionTo + '</td><td>' + FullCustomerTransaction[i].TransactionAmount + '</td></tr>');
//    }
//}

//Append transaction history Employee transactions
for (var i = 0; i < FullCustomertoCustomerTransaction.length; i++) {
    $("#TransactionHistory").append('<tr><td>' + FullCustomertoCustomerTransaction[i].TransactionFrom + '</td><td>' + FullCustomertoCustomerTransaction[i].TransactionTo + '</td><td>' + FullCustomertoCustomerTransaction[i].TransactionAmount + '</td></tr>');
}

//Customer Send message
$(document).on("click", "#AskSend", function() {
    var sAskName = $("#AskFirstName").val();
    var sAskMessage = $("#AskMessage").val();

    var MessageInfo = {"name": sAskName, "message": sAskMessage};
    AskMessage.push(MessageInfo);
    localStorage.Message = JSON.stringify(AskMessage);
    $("#LblMessage").append('<div class="messageClass"><div><label>Name:</label>' + ' ' + '' + sAskName + '</div><div><label>Message:</label><br>' + sAskMessage + '</div></div><br>');
});

AskMessage = JSON.parse(localStorage.Message);
for (var i = 0; i < AskMessage.length; i++) {
    $("#LblMessage").append('<div class="messageClass"><div><label>Name:</label>' + ' ' + '' + AskMessage[i].name + '</div><div><label>Message:</label><br>' + AskMessage[i].message + '</div></div><br>');
}

//Edit customer information
$(document).on("click", "#editInformation", function() {
    $('.EditInformationInputs').fadeIn("slow");
});

$(document).on("click", "#SaveInformation", function() {
    var EditName = $('#EditFirstname').val();
    var EditLastName = $('#EditLastname').val();
    var EditPhone = $('#EditPhone').val();
    var EditPass = $('#EditPass').val();

    for (var i = 0; i < gCustomers.length; i++) {
        if (gCustomers[i].name == loggedInCustomer.name) {
            loggedInCustomer.name = EditName;
            loggedInCustomer.Lastname = EditLastName;
            loggedInCustomer.phone = EditPhone;
            loggedInCustomer.pass = EditPass;
        }
    }
    localStorage.Customers = JSON.stringify(gCustomers);
});

//Logins modal

for (var i = 0; i < ArrayOfEmployees.length; i++) {
    $('#EmployeeLoginModal').append('<tr><td>' + ArrayOfEmployees[i].name + '</td><td>' + ArrayOfEmployees[i].pass + '</td></tr>');
}

for (var i = 0; i < gCustomers.length; i++) {
    $('#CustomerLoginModal').append('<tr><td>' + gCustomers[i].name + '</td><td>' + gCustomers[i].pass + '</td></tr>');
}
//Document ready end!
//});