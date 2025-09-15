<!-- Login Modal (Bootstrap) -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Iniciar sesión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="mail">Usuario</label>
            <input type="text" class="form-control" id="mail" name="mail" placeholder="Ingrese su usuario" required>
          </div>
          <div class="form-group">
            <label for="psw">Contraseña</label>
            <input type="password" class="form-control" id="psw" name="psw" placeholder="Ingrese su contraseña" required>
          </div>
          <div class="d-flex justify-content-between">
            <a href="#" id="lost">¿Olvidó su contraseña?</a>
            <a href="#" id="nuser">¿Nuevo usuario?</a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" id="cancel">Cancelar</button>
          <button type="submit" name="login" class="btn btn-success">Entrar</button>
        </div>
      </form>
    </div>
  </div>
 </div>

<!-- Register Modal (Bootstrap) -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Crear cuenta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="regmail">Email</label>
            <input type="email" class="form-control" id="regmail" name="regmail" placeholder="Correo electrónico" required>
          </div>
          <div class="form-group">
            <label for="regname">Nombre</label>
            <input type="text" class="form-control" id="regname" name="regname" placeholder="Ingrese su nombre" required>
          </div>
          <div class="form-group">
            <label for="regpsw">Contraseña</label>
            <input type="password" class="form-control" id="regpsw" name="regpsw" placeholder="Ingrese su contraseña" required>
          </div>
          <div class="form-group">
            <label for="regpsw2">Confirmar contraseña</label>
            <input type="password" class="form-control" id="regpsw2" name="regpsw2" placeholder="Repita su contraseña" required>
          </div>
          <div id="display" class="small text-danger"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" id="cancelReg">Cancelar</button>
          <button type="submit" name="registro" id="registro" class="btn btn-primary">Registrarse</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  (function(){
    var $loginLink = document.getElementById('login');
    var $ctaCreate = document.getElementById('nuser2');
    var $toRegister = document.getElementById('nuser');
    var $toLost = document.getElementById('lost');

    if ($loginLink) {
      $loginLink.addEventListener('click', function(e){ e.preventDefault(); $('#loginModal').modal('show'); });
    }
    if ($ctaCreate) {
      $ctaCreate.addEventListener('click', function(e){ e.preventDefault(); $('#loginModal').modal('hide'); $('#registerModal').modal('show'); });
    }
    if ($toRegister) {
      $toRegister.addEventListener('click', function(e){ e.preventDefault(); $('#loginModal').modal('hide'); $('#registerModal').modal('show'); });
    }
    if ($toLost) {
      $toLost.addEventListener('click', function(e){ e.preventDefault(); $('#loginModal').modal('hide'); /* implementar flujo de recuperación si aplica */ });
    }

    var reg1 = document.getElementById('regpsw');
    var reg2 = document.getElementById('regpsw2');
    var display = document.getElementById('display');
    if (reg1 && reg2) {
      var btn = document.getElementById('registro');
      var check = function(){
        if (reg1.value && reg2.value && reg1.value !== reg2.value) {
          display.textContent = 'Las contraseñas deben ser iguales';
          if (btn) btn.setAttribute('disabled','disabled');
        } else {
          display.textContent = '';
          if (btn) btn.removeAttribute('disabled');
        }
      };
      reg1.addEventListener('input', check);
      reg2.addEventListener('input', check);
    }
  })();
 </script>
