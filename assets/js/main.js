//Rename
function rename(obj, atual){
    var nome = window.prompt("Digite o novo nome:", '');
    if(nome != ''){
        window.location.href = "index.php?rename="+obj+"&new="+nome+'&folder='+atual+'&action=true';
    }
}

//Actions
function actions(obj, path, action){


    var http = new XMLHttpRequest();
    var url = 'explorer.php';
    if(action == 'renomear'){
        var nome = window.prompt("Digite o novo nome:", obj);
        if(nome != '' && nome != null){
            var params = 'rename='+obj+'&newname='+nome+'&folder='+path+'&action=true';
        }else{
        return false;
        }
    } else if(action == 'abrir'){
        var params = 'folder='+obj+'&action=true';
    } else if(action == 'new') {
        var n = document.getElementById('newitem').value;
        if(n != '' && n != null){
            if(obj == 'folder'){
                var params = 'new='+n+'&type='+obj+'&folder='+path+'&action=true';
            } else if(obj == 'file'){
                var params = 'new='+n+'&type='+obj+'&folder='+path+'&action=true';
            }            
        }           
    }else if(action == 'deletar'){  
        if(confirm("Deseja mesmo deletar "+obj)){
            var params = 'delete='+obj+'&folder='+path+'&action=true';
        }
    }else if(action == 'download'){  
        var params = 'download='+obj+'&folder='+path+'&action=true';
    }else if(action == 'changedomain'){
	var params = 'domainchange='+obj.value+'&folder='+path+'&action=true';
    }
       
    
    http.open('POST', url, true);
    //Send the proper header information along with the request
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    http.onreadystatechange = function() {//Call a function when the state changes.
        if(http.readyState == 4 && http.status == 200) {
           document.getElementById('pageContent').innerHTML = http.responseText;
        }
    }
    http.send(params);
}


//Delete File
function delet(obj){
document.getElementById('confirm').innerHTML='<button class="btn btn-danger" type="button" data-load-content="sites/file_manager.php?delete='+obj+'">Confirm Delete</button>';
}

function setnew(type, atual){
    var n = document.getElementById('newitem').value;
    if(n != '' && n != null){
        window.location.href = "index.php?new="+n+"&type="+type+'&folder='+atual;
    }
}

