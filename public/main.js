const element = document.getElementById.bind(document);
function on(elementID, event, handler){
    let e = element(elementID);
    if(e){
        e.addEventListener(event, handler);
    }
}
function ajax(params,callback){
    let r = new XMLHttpRequest();
    r.open("post","?p=ajax",true);
    r.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    r.onreadystatechange = function(){
        if(r.readyState!=4) return;
        if(r.status==200) {
            let res;
            try{res = JSON.parse(r.response);}
            catch(e){res = r.response;}
            callback(res);
        }
        else console.log(r.status+" "+r.statusText);
    };
    r.send(Object.keys(params).map(function(key){
        return key+"="+encodeURIComponent(params[key]);
    }).join("&"));
}
function elementValue(elementID,defaultValue){
    let e = element(elementID);
    if(!e) return defaultValue;
    return (typeof e.value === "undefined") ? e.innerHTML : e.value;
}
function watchPasswordInputs(input1,input2,button,status,callback){
    if(typeof input1 === "string") input1 = element(input1);
    if(typeof input2 === "string") input2 = element(input2);
    if(typeof button === "string") button = element(button);
    if(typeof status === "string") status = element(status);
    if(button) button.disabled = true;
    input1.onkeyup = input2.onkeyup = function(){
        if(!(input1.value.length && input2.value.length)) return;
        if(input1.value == input2.value){
            if(status) status.innerHTML="";
            if(button) button.disabled=false;
            if(callback) callback(true);
        } else {
            if(status) status.innerHTML="Hesla se neshodují!";
            if(button) button.disabled=true;
            if(callback) callback(false);
        }
    }
}
if(element("register-form")){ // register.twig
    const input = element("reg-heslo2");
    const invalid = "is-invalid";
    const loginRegex = /^[0-9A-Za-z\-_]+$/i;
    watchPasswordInputs("reg-heslo",input,"reg-submit",0,function(valid) {
        if (valid)
            input.classList.remove(invalid);
        else input.classList.add(invalid);
    });
    on("reg-login","keyup",function(ev){
        let value = ev.target.value;
        if(value && !loginRegex.test(value)){
            ev.target.classList.add(invalid);
        } else {
            ev.target.classList.remove(invalid);
        }
    });
}
if(element("password-change")){ // profile.twig
    const targetUser = +elementValue("profile-id",-1);
    let currentRole = +elementValue("profile-role");
    function updateUser(field,value,callback){
        ajax({
            a: "update_user",
            id: targetUser,
            "current-role": currentRole,
            field: field,
            value: value
        }, callback);
    }
    on("profile-role","change",function(ev){
        let newRole = +ev.target.value
        updateUser("role",newRole,function(response){
            element("profile-role-result").innerHTML = response.success ?
                (currentRole=newRole,
                    "Role byla změněna na "+ev.target[newRole].innerHTML+"."
                ) : "Při změně role došlo k chybě.";
        });
    });
    on("profile-activate","click",function(ev){
        let out = element("profile-activate-result");
        let is = out.innerHTML.indexOf("Povolen")!==-1;
        updateUser("povolen",is?"N":"A",function(){
            out.innerHTML = is ? "Zakázán" : "Povolen";
            ev.target.value = is ? "Povolit" : "Zakázat";
        });
    });
    watchPasswordInputs("password1","password2","password-change","password-status");
    on("password-change","click",function(){
        updateUser("heslo", elementValue("password1"),function(response){
            element("password-status").innerHTML = response.success ?
                "Heslo bylo změněno." : "Při změně hesla došlo k chybě.";
        });
    });
}
