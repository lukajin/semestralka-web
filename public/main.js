function element(elementID){
    return (elementID instanceof HTMLElement)
        ? elementID
        : document.getElementById(elementID);
}
function on(elementID, event, handler){
    let e = element(elementID);
    if(e){
        e.addEventListener(event, handler);
    }
}
function ajax(params,callback){
    let f = new FormData();
    for(let key of Object.keys(params)){
        f.append(key,params[key]);
    }
    let r = new XMLHttpRequest();
    r.open("post","?p=ajax",true);
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
    r.send(f);
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
else if(element("password-change")){ // profile.twig
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
else if(element("post-update")){ // post.twig, úprava příspěvku (ne nový)
    const id = elementValue("post-id"),
        title = element("post-title"),
        abstract = element("post-abstract"),
        file = element("post-file"),
        updateButton = element("post-update"),
        uploadButton = element("post-upload"),
        updateResponse = element("post-update-response"),
        uploadResponse = element("post-upload-response");
    let currentTitle = elementValue(title),
        currentAbstract = elementValue(abstract);
    function enableButton(){
        updateResponse.innerHTML="";
        uploadResponse.innerHTML="";
        this.disabled = false;
    }
    const enableUpdate = enableButton.bind(updateButton);
    on(title,"keyup",enableUpdate);
    on(abstract,"keyup",enableUpdate);
    on(file,"input",enableButton.bind(uploadButton));

    on(updateButton,"click",function(){
        let newTitle = elementValue(title),
            newAbstract = elementValue(abstract);
        if(newTitle === currentTitle && newAbstract === currentAbstract){
            return;
        }
        ajax({
            a: "update_post",
            id: id,
            nazev: newTitle,
            abstrakt: newAbstract
        },function(response){
            if(response && response.success){
                updateButton.disabled = true;
                updateResponse.innerHTML = "Změny uloženy.";
                currentTitle = newTitle;
                currentAbstract = newAbstract;
            }
            else updateResponse.innerHTML = "Při ukládání změn došlo k chybě.";
        });
    });
    on(uploadButton,"click",function(){
        ajax({
            a: "update_post",
            id: id,
            soubor: file.files[0]
        },function(response){
            if(response && response.success){
                file.value = "";
                uploadResponse.innerHTML = "Soubor byl nahrán.";
                element("file-link").href="uploads/"+response.file;
                if(element("uploaded-file").classList.contains("d-none")){
                    element("uploaded-file").classList.remove("d-none");
                    element("no-file").classList.add("d-none");
                }
            }
            else {
                uploadButton.disabled = false;
                uploadResponse.innerHTML = "Při nahrávání souboru došlo k chybě.";
            }
        });
        uploadButton.disabled = true;
        uploadResponse.innerHTML = "Nahrávání souboru...";
    });
    window.addEventListener("beforeunload", function (ev) {
        let msg = null;
        if(elementValue(title) !== currentTitle
            || elementValue(abstract) !== currentAbstract){
            msg="V příspěvku byly provedeny změny, které nebyly uloženy.\n" +
                "Opuštěním této stránky budou tyto změny ztraceny.\n" +
                "Opravdu chcete stránku opustit?";
        }
        else if(file.value){
            msg="Vybraný soubor nebyl nahrán.\n" +
                "Opravdu chcete stránku opustit?"
        }
        if(msg){
            ev.preventDefault();
            ev.returnValue = msg;
            return msg;
        }
    });
}
