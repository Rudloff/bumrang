/*global window _ Gettext*/

var i, j;
var edited;
var numVal;
var clickPos;
var readCookie =function(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)===' ') {c = c.substring(1,c.length);}
        if (c.indexOf(nameEQ) === 0) {return c.substring(nameEQ.length,c.length);}
    }
    return null;
};

var init=function(){
    Gettext.lang = 'fr';
    
    
    var checkClick=function(enter){
        if((edited && this.parentNode!==edited) || (edited && enter)){
            //window.alert("Out!");
            var inputs=["id", "name", "firstname", "email", "other1", "other2", "other3", "other4"];
            
            
            var form=document.createElement("form");
            form.setAttribute("method", "post");
            var hidden=document.createElement("input");
            hidden.setAttribute("type", "hidden");
            hidden.setAttribute("name", "update");
            hidden.setAttribute("value", true);
            
            var num=document.createElement("input");
            num.setAttribute("value", numVal);
            num.setAttribute("name", "num");
            num.setAttribute("type", "hidden");
            
            
            for(i=0; i<edited.children.length-4; i++){
                var input=document.createElement("input");
                input.setAttribute("type", "hidden");
                input.setAttribute("name", inputs[i]);
                input.setAttribute("value", edited.children[i+1].firstChild.value);
                form.appendChild(input);
            }    
            
            var date1_send=document.createElement("input");
            date1_send.setAttribute("type", "hidden");
            date1_send.setAttribute("name", "date1");
            var date1_send_old=edited.getElementsByClassName("date1_input")[0];
            date1_send.setAttribute("value", date1_send_old.value);
            form.appendChild(date1_send);
            
            
            
            form.appendChild(hidden);
            form.appendChild(num);
            
            document.body.appendChild(form);
            
            var date1_time=new Date(date1_send_old.value);
            if(date1_time=="Invalid Date"){
                window.alert(_("Invalid Date!"));
            }else{
                date1_time=date1_time.getTime();
                var date2_time=new Date();
                date2_time=date2_time.getTime();
                if(date1_time>date2_time){
                    window.alert(_("Error:")+" "+_("This date is earlier than today!"));    
                }else{
                    form.submit();
                }
            }
        }    
    };
    
    if(document.addEventListener){
        document.addEventListener('click',checkClick,false);
    }
    
    var askConfirm=function(element, string){
        element.onclick=function(){
            if(window.confirm(string)) { 
                return true;
            }else{
                return false;    
            }
        };
    };
    
    
    var extendButtons=document.getElementsByClassName("extendButton");
    for(i=0; i<extendButtons.length; i++){
        var extendButton=extendButtons[i];
        var extendNum=extendButton.parentNode.getElementsByClassName("extendNum")[0].value;
        if(extendNum>0) { 
            askConfirm(extendButton, _("This borrow has already been extended %d time(s).", extendNum)+"\n"+_("Are you sure you want to extend it again?"));
            
        }
    }
    
    var deleteButtons=document.getElementsByClassName("deleteButton");
    for(i=0; i<deleteButtons.length; i++){
        var deleteButton=deleteButtons[i];
        askConfirm(deleteButton, _("Are you sure you want to delete this entry?"));
    }
    
    window.onkeypress=function(event){
        if(event.keyCode===13 && edited){
            checkClick(true);
        }    
    };
    
    
    
    
};
window.onload=function(){
    document.addEventListener("GettextLoad", init, false);    
    
    
    var makeEditable=function(element){
        element.onclick=function(event){
            if(document.addEventListener){
                if(this.firstChild.tagName!=="INPUT" && this.firstChild.tagName!=="FORM" && !edited){
                    edited=this.parentNode;
                    numVal=edited.children[0].firstChild.children[1].getAttribute("value");
                    
                    
                    var TRs=this.parentNode.getElementsByTagName("td");
                    for(i=0; i<TRs.length; i++){    
                        if(TRs[i]===this){
                            clickPos=i;    
                        }
                        
                    }
                    var id=document.createElement("input");
                    var name=document.createElement("input");
                    var firstname=document.createElement("input");
                    var email=document.createElement("input");
                    var other1=document.createElement("input");
                    var other2=document.createElement("input");
                    var other3=document.createElement("input");
                    var other4=document.createElement("input");
                    
                    id.setAttribute("name", "id");
                    email.setAttribute("type", "email");
                    var inputs=[id, name, firstname, email, other1, other2, other3, other4];
                    
                    for(i=1; i<edited.children.length-3; i++){    
                        if(edited.children[i].textContent){
                            inputs[i-1].setAttribute("value", edited.children[i].textContent);
                        }else if(edited.children[i].innerText){
                            inputs[i-1].setAttribute("value", edited.children[i].innerText);    
                        }
                        edited.children[i].innerHTML="";
                        edited.children[i].appendChild(inputs[i-1]);
                        
                    }
                    var date1=document.createElement("input");
                    date1.setAttribute("type", "date");
                    date1.setAttribute("class", "date1_input");
                    var date1_old=edited.getElementsByClassName("date1")[0];
                    if(date1_old.textContent){
                        date1.setAttribute("value", date1_old.textContent);
                    }else if(date1_old.innerText){
                        date1.setAttribute("value", date1_old.innerText);
                    }
                    date1_old.innerHTML="";
                    date1_old.appendChild(date1);
                    
                    if(edited.children[clickPos].firstChild.focus){
                        edited.children[clickPos].firstChild.focus();
                    }
                    
                }
                if(edited && this.parentNode===edited){
                    if(event){
                        event.stopPropagation();
                    }
                }
            }
            
        };    
    };
    
    var Table=function(hideButton, table, rows, name){
        this.hideButton=hideButton;
        this.table=table;
        this.rows=rows;
        this.name=name;
    };
    
    var mainTable=new Table("", document.getElementById("mainTable"), document.getElementById("mainTable").getElementsByTagName("tr"), "mainTable");
    for(i=0; i<mainTable.rows.length; i++){    
        var td=mainTable.rows[i].getElementsByTagName("td");
        for(j=1; j<td.length-1; j++){
            makeEditable(td[j]);
        }
    }
    
    
    
    
    
    var otherTable=new Table(document.getElementById("hideReturned"), document.getElementById("otherTable"), document.getElementById("otherTable").getElementsByTagName("tr"), "otherTable");
    var hideTable=function(tableObject){
        document.cookie="show_"+tableObject.name+"=false;";    
        tableObject.hidden=true;
        for(i=0; i<tableObject.rows.length; i++){    
            tableObject.rows[i].style.visibility="hidden";
            tableObject.hideButton.setAttribute("class", "hide");
        }
    };
    var showTable=function(tableObject){
        document.cookie="show_"+tableObject.name+"=true;";    
        
        tableObject.hidden=false;
        for(i=0; i<tableObject.rows.length; i++){
            tableObject.rows[i].style.visibility="visible";
            tableObject.hideButton.setAttribute("class", "show");
        }
    };
    otherTable.hideButton.onclick= function(event){
        if(event){
            event.stopPropagation();
        }
        if(!otherTable.hidden){
            hideTable(otherTable);
        }else{
            showTable(otherTable);
        }
    };
    if(readCookie("show_otherTable")!=="true"){
        hideTable(otherTable);
    }
};
