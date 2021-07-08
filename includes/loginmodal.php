<div id="id01" class="login modal">

    <form class="login modal-content animate" action="" method="post">
        <div class="login container">
            <label for="mail"><b>Usuario</b></label>
            <input type="text" placeholder="Ingrese su usuario" name="mail" required>

            <label for="psw"><b>Contraseña</b></label>
            <input type="password" placeholder="Ingrese su contraseña" name="psw" required>
            <div class="container">
                <div class="row">
                    <input type="submit" name="login" class="btn btn-success col-md-6" value="Entrar">
                    <button type="button" id="cancel" class="btn btn-danger col-md-6">Cancelar</button>
                </div>
            </div>
        </div>

        <div class="login container" style="background-color:#f1f1f1">
            <label for="" class="login">Olvido su <a href="#lost" id="lost">contraseña?</a></label>
            <label for="" class = "login">Nuevo <a href="#nuser" id="nuser">usuario?</a></label>
        </div>
    </form>
</div>

<div id="id02" class="login modal">
    <form action="" method="post" class="login modal-content animate">
        <div class="login container">
            <label for="regmail"><b>Email</b></label>
            <input type="text" placeholder="Correo electronico" name="regmail" required>

            <label for="regname"><b>Nombre</b></label>
            <input type="text" placeholder="Ingrese su nombre" name="regname" required>

            <label for="regpsw2"><b>Contraseña</b></label>
            <input type="password" placeholder="Ingrese su Contraseña" name="regpsw" required>

            <label for="regpsw2"><b>Contraseña</b></label>
            <input type="password" placeholder="Ingrese nuevamente su Contraseña" name="regpsw2" required>
            <div id="display"></div>

            <div class="container">
                <div class="row">
                    <input type="submit" name="registro" class="btn btn-success col-md-6" value="Entrar">
                    <button type="button" id="cancelReg" class="btn btn-danger col-md-6">Cancelar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Get the modal
    var loginModal = document.getElementById('id01');
    var regModal = document.getElementById('id02');
    var lostModal = document.getElementById('id03');
    var login = document.getElementById('login');
    var nuser2 = document.getElementById('nuser2');
    var lost = document.getElementById('lost');
    var nuser = document.getElementById('nuser');
    var cancel = document.getElementById('cancel');
    var cancelReg = document.getElementById('cancelReg');

    //cuando el usuario da click en la palabra 'iniciar sesion' del encabezado el modal se abre
    login.onclick = function(){
        loginModal.style.display='block';
    }
    
    //cuando el usuario da click en la palabra 'iniciar sesion' del encabezado el modal se abre
    try {
  nuser2.onclick = function(){
        loginModal.style.display = 'none';
        regModal.style.display = 'block';
    }
} catch (error) {
  console.error(error);
  // expected output: ReferenceError: nonExistentFunction is not defined
  // Note - error messages will vary depending on browser
}
    

    //cuando el usuario da click en 'registro' se cerrara el modal para abrir el del registro
    nuser.onclick = function(){
        loginModal.style.display = 'none';
        regModal.style.display = 'block';
    }

    //cuando el usuario da click en 'contrasena' se cerrara el modal para abrir el del restaurar pass
    lost.onclick = function(){
        loginModal.style.display = 'none';
    }

    //boton cancelar del modal que lo cerrara
    cancel.onclick = function(){
        loginModal.style.display = 'none';  
    }
    cancelReg.onclick = function(){
        regModal.style.display = 'none';
    }

    //cuando el usuario da click fuera del modal este se cierra
    window.onclick = function(event) {
        if (event.target == loginModal) {
            loginModal.style.display = 'none';
        }
        if (event.target == regModal){
            regModal.style.display = 'none';
        }
    }

    function iguales(obj){
        var val = obj.value;
        var val2 = document.getElementById('regpsw').value;
        var btn = document.getElementById('registro');
        var dis = document.getElementById('displaylog');
        if(val != val2){
            dis.innerHTML = "Las contraseñas deben ser iguales";
            btn.setAttribute('hidden','');
            btn.className += 'btnerr';
        }else{
            dis.innerHTML = " ";
            btn.removeAttribute('hidden');
            btn.className = 'ok';
        }
    }
</script>