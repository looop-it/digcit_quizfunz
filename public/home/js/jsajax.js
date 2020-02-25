/*   #################################*/


/******************原生js验证***********************/  

//验证用户名
function check_userName(id) {
  var userNameNode = document.getElementsByName(id)[0]; 

 var ns=getNextSibilingsNode(userNameNode);    

   var userName = document.getElementsByName(id)[0].value;  
     
  var regName = /[\u4e00-\u9fa5]{2,6}/   
  if (userName == "" || userName.trim() == "") {
    ns.innerHTML = "請輸入名稱";
         ns.style.color = "red";   
    return false;
  } else if (!regName.test(userName)) {
    ns.innerHTML = "請輸入正確的名稱";
         ns.style.color = "red";  
    return false;  
  } else {
    ns.innerHTML = "通过信息验证！";
     ns.style.color = "#71b83d";  
    return true;
  }  
}


//验证用户名
function check_contactPerson(id) {
    var userNameNode = document.getElementsByName(id)[0];

    var ns=getNextSibilingsNode(userNameNode);

    var userName = document.getElementsByName(id)[0].value;

    var regName = /^[\u4E00-\u9FA5A-Za-z].{2,20}$/
    if (userName == "" || userName.trim() == "") {
        ns.innerHTML = "請輸入負責老師姓名";
        ns.style.color = "red";
        return false;
    } else if (!regName.test(userName)) {
        ns.innerHTML = "請輸入正確的負責老師姓名·";
        ns.style.color = "red";
        return false;
    } else {
        ns.innerHTML = "通过信息验证！";
        ns.style.color = "#71b83d";
        return true;
    }
}

//验证邮箱
function check_email(id) {
  var userNameNode = document.getElementsByName(id)[0]; 

 var ns=getNextSibilingsNode(userNameNode);    

   var email = document.getElementsByName(id)[0].value;  
  var regEmail = /^\w+@\w+((\.\w+)+)$/;  
  if (email == "" || email.trim() == "") {
   ns.innerHTML = "請輸入通訊電郵";
        ns.style.color = "red";  
    return false;
  } else if (!regEmail.test(email)) {
   ns.innerHTML = "請輸入正確的電郵格式";
        ns.style.color = "red";  
    return false;
  } else {  
    ns.innerHTML = "通过信息验证！";
     ns.style.color = "#71b83d";  
    return true;
  }
}

//验证密码
function check_pwd(id) {  
  var userNameNode = document.getElementsByName(id)[0]; 

 var ns=getNextSibilingsNode(userNameNode);    

   var pwd = document.getElementsByName(id)[0].value;   
  var regPwd = /^\w{6,15}$/;  
  if (pwd == "" || pwd.trim() == "") {
   ns.innerHTML = "請輸入密碼";
       ns.style.color = "red";  
    return false;
  } else if (!regPwd.test(pwd)) {
    ns.innerHTML = "請輸入6到15個字符";   
        ns.style.color = "red";  
    return false;
  } else {
    ns.innerHTML = "通过信息验证！";
     ns.style.color = "#71b83d";  

    return true;
  }
}
//  
function check_fax(id){
  var userNameNode = document.getElementsByName(id)[0]; 

 var ns=getNextSibilingsNode(userNameNode);    

   var fax = document.getElementsByName(id)[0].value;   
  var regPwd = /^((\+?[0-9]{2,4}\-[0-9]{3,4}\-)|([0-9]{3,4}\-))?([0-9]{7,8})(\-[0-9]+)?$/;  
  if (fax == "" || fax.trim() == "") {
   ns.innerHTML = "請輸入傳真號碼";
       ns.style.color = "red";  
    return false;
  } else if (!regPwd.test(fax)) {
    ns.innerHTML = "請輸入正確的傳真號碼格式";
        ns.style.color = "red";  
    return false;  
  } else {
    ns.innerHTML = "通过信息验证！";
     ns.style.color = "#71b83d";      

    return true;
  }


}


//验证确认密码
function check_repwd(id,name) {  
  var userNameNode = document.getElementsByName(id)[0]; 

 var ns=getNextSibilingsNode(userNameNode);    

   var pwd = document.getElementsByName(id)[0].value;  
   var pwdName = document.getElementsByName(name)[0].value;    
  if (pwd == "" || pwd.trim() == "") {
   ns.innerHTML = "請輸入密碼";
       ns.style.color = "red";  
    return false;
  } else if (pwdName!=pwd) {
    ns.innerHTML = "密碼不一至";
        ns.style.color = "red";  
    return false;  
  } else {
    ns.innerHTML = "通过信息验证！";
     ns.style.color = "#71b83d";  
    return true;
  }
} 

//验证学校 
function check_Shool(name) {
  var userNameNode = document.getElementsByName(name)[0]; 

 var ns=getNextSibilingsNode(userNameNode);    

   var school = document.getElementsByName(name)[0].value;   
  var regName =/^([\u4e00-\u9fa5]|[\u4e00-\u9fa5]|[a-za-z0-9_]){3,150}$/        
  if (school == "" || school.trim() == "") {
   ns.innerHTML = "請輸入學校名稱";
       ns.style.color = "red";     
    return false;
  } else if (!regName.test(school)) {
    ns.innerHTML = "請輸入合法的學校名稱";
    ns.style.color = "red";
    return false;
  } else {
    ns.innerHTML = "通过信息验证！";
     ns.style.color = "#71b83d";  
    return true;
  }
}
//验证手机号
function check_phone(phone) {
  var userNameNode = document.getElementsByName(phone)[0]; 

 var ns=getNextSibilingsNode(userNameNode);    

   var phoneName = document.getElementsByName(phone)[0].value; 
  var regPhone = /^[1][3|4|5|6|7|8]\d{9}$|^([5|6|8|9])\d{7}$|^[6]([8|6])\d{5}$/;      
  if (phoneName == "" || phoneName.trim() == "") {
    ns.innerHTML = "請輸入聯絡電話";
        ns.style.color = "red";
    return false;
  } else if (!regPhone.test(phoneName)) {    
    ns.innerHTML = "請輸入正確的聯絡電話格式";
        ns.style.color = "red";
    return false;
  } else {
    ns.innerHTML = "通过信息验证！";
     ns.style.color = "#71b83d";  
    return true;
  }        
}

function check_expected_participants(expected_participants){

  var userNameNode = document.getElementsByName(expected_participants)[0]; 

 var ns=getNextSibilingsNode(userNameNode);    

   var phoneName = document.getElementsByName(expected_participants)[0].value; 
  var regPhone = /^[0-9]*$/;    
  if (phoneName == "" || phoneName.trim() == "") {
    ns.innerHTML = "請輸入預計參賽學生人數 (最少50人)";
        ns.style.color = "red";
    return false;
  } else if (!regPhone.test(phoneName)) {
    ns.innerHTML = "請輸入合法的預計參賽學生人數 (最少50人)";
        ns.style.color = "red";
    return false;
  } else {
    ns.innerHTML = "通过信息验证！";
     ns.style.color = "#71b83d";  
    return true;
  } 

}


function check_students(name){

  var userNameNode = document.getElementsByName(name)[0]; 

 var ns=getNextSibilingsNode(userNameNode);    

   var students = document.getElementsByName(name)[0].value; 
  var regPhone = /^[0-9]*$/;    
  if (students == "" || students.trim() == "") {
    ns.innerHTML = "請輸入全校學生人數";
        ns.style.color = "red";
    return false;
  } else if (!regPhone.test(students)) {      
    ns.innerHTML = "請輸入合法的全校學生人數";
        ns.style.color = "red";
    return false;   
  } else {
    ns.innerHTML = "通过信息验证！";
     ns.style.color = "#71b83d";  
    return true;
  } 


}
function check_school_id(school_id){
  var userNameNode = document.getElementsByName(school_id)[0]; 

 var ns=getNextSibilingsNode(userNameNode);    

   var phoneName = document.getElementsByName(school_id)[0].value; 
  var regPhone = /^[0-9]*$/;    
  if (phoneName == "" || phoneName.trim() == "") {
    ns.innerHTML = "請選擇學校";
        ns.style.color = "red";
    return false;
  } else if (!regPhone.test(phoneName)) {    
    ns.innerHTML = "請選擇學校";         
        ns.style.color = "red";
    return false;
  } else {
    ns.innerHTML = "通过信息验证！";
     ns.style.color = "#71b83d";    
    return true;
  } 


}





$(function () {
     var errMsg;
     $.each($("input"), function (i, val) {
       $(val).blur(function () {
       
         if ($(val).attr("name") == "userName") {
  
              check_userName("userName");        
              
         } 
         if($(val).attr("name") == "email"){

          check_email('email');
         }
         if($(val).attr("name") == "pwd"){

          check_pwd('pwd');  
         }
        if($(val).attr("name") == "password_confirmation"){  

          check_repwd('password_confirmation','pwd');   
        }
        if($(val).attr("name") == "school"){

          check_Shool('school');  
        }
        if($(val).attr("name") == "phone"){

          check_phone('phone');
        }   
        if($(val).attr("name") == "expected_participants"){

          check_expected_participants('expected_participants');
        }
         if($(val).attr("name") == "fax"){

          check_fax('fax');      
         }

         if($(val).attr("name") == "students"){

          check_students('students');
         }
  
/*  学生登记验证*/  

        if($(val).attr("name") == "password"){

                check_pwd('password');  
               } 

          if ($(val).attr("name") == "name") {
  
              check_userName("name");          
              
         } 
        if($(val).attr("name") == "repassword"){  

          check_repwd('repassword','password');   
        }         
        if($(val).attr("name") == "school_id"){  

          check_school_id('school_id');      
        }    


       });

/*  
            $(val).on("keyup paste",function(){
                 alert(34232);
            });*/
 /*    时时改变事件*/  
        $(val).bind("input propertychange", function(){
             
               if ($(val).attr("name") == "userName") {
        
                    check_userName("userName");        
                    
               } 
               if($(val).attr("name") == "email"){

                check_email('email');
               }
               if($(val).attr("name") == "pwd"){

                check_pwd('pwd');  
               }
              if($(val).attr("name") == "password_confirmation"){  

                check_repwd('password_confirmation','pwd'); 
              }
              if($(val).attr("name") == "school"){

                check_Shool('school');  
              }
              if($(val).attr("name") == "phone"){

                check_phone('phone');
              }  

            if($(val).attr("name") == "expected_participants"){

              check_expected_participants('expected_participants');
            }
           if($(val).attr("name") == "fax"){

          check_fax('fax');      
         }   
                  if($(val).attr("name") == "students"){

          check_students('students');
         }  



/*  学生登记验证*/
         if ($(val).attr("name") == "name") {
  
              check_userName("name");          
                
         }  
        if($(val).attr("name") == "password"){

                check_pwd('password');  
               } 
        if($(val).attr("name") == "repassword"){  

          check_repwd('repassword','password');   
        }     

        });

       if($(val).attr("name") == "school_id"){  

          check_school_id('school_id');       
        }   

     });  


   });

  
/*select 改变事件*/
  $('#school_id').bind("change",function(){

           check_school_id('school_id');       

  });  

   
    

 function getNextSibilingsNode(ele) {
    var parsent = ele.parentNode;//获取元素父元素
    var childrens = parsent.childNodes;//获取兄弟元素
    var i = 0;
    for(i; i < childrens.length; i++) {
        if(childrens[i].nodeType == 1 && childrens[i] == ele){//元素节点nodeType值为1，剔除文本节点
            if(childrens[i+1].nodeType == 1){//防止li之间没有换行，直接选择下一个i+1
                return childrens[i+1];
            }if(childrens[i+2].nodeType == 1){//跳过文本节点，所以i+2
                return childrens[i+2];
            }
            else{
                throw error("传入的元素出错，请检查，可能这是最后一个元素");
            }
        }
    }
}