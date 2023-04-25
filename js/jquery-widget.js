$(document).ready(function() {
    $('.slideshow').cycle({
		fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
	});
});

function validate() 
{
var acctype = document.getElementById('reg_acctype');
var fname = document.getElementById('reg_fname');
var lname = document.getElementById('reg_lname');
var month = document.getElementById('month');
var day = document.getElementById('day');
var year = document.getElementById('year');
var address = document.getElementById('reg_address');
var username = document.getElementById('reg_username');
var password = document.getElementById('reg_password');
var photo = document.getElementById('reg_photo');
var filter =  /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
var filter1 = /^\d{3}-[_A-Za-z1-9]{2}-\d{3}[A-Z]{2}$/;
var filter2 = /^([A-Z]{3})-\d{2}-\d{4}-[FM]{1}$/;
var filter3 = /^\S{5,}$/;
    
    if(fname.value == "" || lname.value == "" || address.value == "" || username.value == "" || password.value == "" 
        || acctype.value == "0" || month.value == "0"  || day.value == "0" || year.value == "0")
    {
        if (month.value == "0" || day.value == "0" || year.value == "0")        
        {$("#neededbday").html('*');}
        else {$("#neededbday").html('');}
        if (password.value == "")        
        {$("#neededpass").html('*'); password.focus();}
        else {$("#neededpass").html('');}
        if (username.value == "")        
        {$("#neededuser").html('*'); username.focus();}
        else {$("#neededuser").html('');}
        if (address.value == "")        
        {$("#neededaddress").html('*'); address.focus();}
        else {$("#neededaddress").html('');}
        if (lname.value == "")
        {$("#neededlname").html('*'); lname.focus();}
        else {$("#neededlname").html('');}
        if(fname.value == "")
        {$("#neededfname").html('*'); fname.focus();}
        else {$("#neededfname").html('');}
        if (acctype.value == "0")
        {$("#neededacct").html('*'); acctype.focus();}
        else {$("#neededacct").html('');}
        alert('Verify fields with (*)');
        return false;
    }
        
    else if (acctype.value == "Parent")
    {
        if (!filter.test(password.value)) 
        {   
            $("span").html('');
            $("#neededpass").html('*');
            alert('Password should be an email address');
            password.focus();
            return false;
        }
    }
    
    else if (acctype.value == "Teacher")
    {
        if (!filter1.test(username.value))
        {
            $("span").html('');
            $("#neededuser").html('*');
            alert('Username must be NNN-xx-NNNLL');
            username.focus();
            return false;
        }
        else if (!filter3.test(password.value))
        {   
            $("span").html('');
            $("#neededpass").html('*');
            alert('Password length must be 5 or more!(spaces not allowed)');
            password.focus();
            return false;
            
        }
     }
     
     else if (acctype.value == "Student")
     {
        if (!filter2.test(username.value))
        {   
            $("span").html('');
            $("#neededuser").html('*');
            alert('Username must be MONTH-DAY-YEAR-GENDER                                   ex. JAN-01-2000-M');
            username.focus();
            return false;
        }
        else if (password.value.length < 5 || password.value.length > 15)
        {   
            $("span").html('');
            $("#neededpass").html('*');
            alert('Password length must not be fewer than 5 but must not exceed 15!');
            password.focus();
            return false;
        }
     }
}

function parentusername() 
{
    var acctype = document.getElementById('reg_acctype');
    var username = document.getElementById('reg_username');
    var lname = document.getElementById('reg_lname');
    
    if(acctype.value == "Parent")
    {
        $("#reg_username").val(lname.value);
    }
}
function disableuser()
{
    var acctype = document.getElementById('reg_acctype');
    var username = document.getElementById('reg_username');    
    var lname = document.getElementById('reg_lname');
    if (acctype.value == "Parent")
    {
        $("#reg_username").val(lname.value);
        username.readOnly = true;
    }
    else
    {
        username.readOnly = false;
    }
}

function bdayCalc() {
    var myDate = new Date();
    var month = document.getElementById('month');
    var day = document.getElementById('day');
    var year = document.getElementById('year');
    var bday = month.value+"/"+day.value+"/"+year.value;
    bday = new Date(bday);

    var diff = Math.floor(myDate.getTime() - bday.getTime());
    var day = 1000* 60 * 60 * 24;
    var days = Math.floor(diff/day);
    var weeks = Math.floor(days/7);
    var months = Math.floor(days/31);
    var years = Math.floor(months/12);

	var message = days + " days old\n" + weeks + " weeks old\n" + months + " months old\n" + years + " years old";
    alert(message);
    return false;
}

setInterval(function clock() {
	var myDate = new Date();
	var subDate = new Date("December 07, 2013 11:59:00");
	var options = {
		hour: "2-digit", minute: "2-digit", second: "2-digit"
	};

	var d = myDate.getDay()+1;
	var DD = myDate.getDate();
	var MM = myDate.getMonth()+1;
	var YYYY = myDate.getFullYear();
	var hh = myDate.getHours();
	var mm = myDate.getMinutes();
	var time = myDate.toLocaleTimeString("en-us", options);
	var event = "";
	var submission = "";
	
	switch (d) {
		case 1: d = "Sunday"; break;
		case 2: d = "Monday"; break;
		case 3: d = "Tuesday"; break;
		case 4: d = "Wednesday"; break;
		case 5: d = "Thursday"; break;
		case 6: d = "Friday"; break;
		case 7: d = "Sunday"; break;            
	}
	if(DD<10){DD='0'+DD;}
	switch (MM) {
		case 1: MM = "January"; break;
		case 2: MM = "Febuary"; break;
		case 3: MM = "March"; break;
		case 4: MM = "April"; break;
		case 5: MM = "May"; break;
		case 6: MM = "June"; break;
		case 7: MM = "July"; break;
		case 8: MM = "August"; break;
		case 9: MM = "September"; break;
		case 10: MM = "October"; break;
		case 11: MM = "November"; break;
		case 12: MM = "December"; break;
	}
	
	if(YYYY == 2013) {
		if(MM == "December" && DD > 07) {

		} else if (DD != 07) {
			var diff = Math.floor(myDate.getTime() - subDate.getTime());
			var day = 1000* 60 * 60 * 24;
			var days = Math.floor(diff/day);
			submission = days + " day/s before machine problem deadline";
		} else if(DD == 07 && MM == "December") {
			if(hh <= 22 ) {
				var diff = 24 - hh;
				submission = diff + " hours before machine problem deadline";
			} else if(hh == 23) {
				var diff = 60 - mm;
				submission = diff + " minutes before machine problem deadline";
			}
		}
	}

	if(MM == "December" && DD == 25) {
		event = "Merry Christmas!";
	}
	if(MM == "January" && DD == 1) {
		event = "Happy New Year!";
	}
	if(MM == "Febuary" && DD == 14) {
		event = "Happy Valentine's Day!";
	}
	if(MM == "October" && DD == 31) {
		event = "Happy Halloween!";
	}
	if(MM == "November" && DD == 30) {
		event = "Happy Bonifacio Day!";
	}
	
	var theme = document.getElementById('theme').value;
	if (hh >= 6 && hh < 18) {
		if (theme == 0) {
			document.getElementById("style").href = "css/style-main.css";
		} else if (theme == 1) {
			document.getElementById("style").href = "css/style-blue.css";
		} else if (theme == 2) {
				document.getElementById("style").href = "css/style-red.css";
		} else if (theme == 3) {
				document.getElementById("style").href = "css/style-pink.css";
		}
	} else {
		if (theme == 0) {
			document.getElementById("style").href = "css/style-darkmain.css";
		} else if (theme == 1) {
			document.getElementById("style").href = "css/style-darkblue.css";
		} else if (theme == 2) {
			document.getElementById("style").href = "css/style-darkred.css";
		} else if (theme == 3) {
			document.getElementById("style").href = "css/style-darkpink.css";
		}
	}
	
	var today = d+', '+DD+' '+MM+' '+YYYY+' '+time;
	document.getElementById("clock").innerHTML = today;
	document.getElementById("event").innerHTML = event;
	document.getElementById("submission").innerHTML = submission;
	return false;
},1000);
