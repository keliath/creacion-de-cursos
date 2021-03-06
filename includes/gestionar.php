<div class="container" style="margin-top:30px">
    <div class="row">
        <div class="col-sm-12">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <h5>Gestion del curso</h5>
                    <hr class="d-sm-none">
                </div>
                <div id="campos" class="campos-opcional">
                    <div class="form-group">
                        <label for="name">Nombre del curso</label>
                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" value="<?php if ($curName != '') {
                                                                                                                    echo $curName;
                                                                                                                } ?>">
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoria del curso</label>
                        <select name="categoria" id="" class="form-control">
                            <option value="">Selecciona una Categoria</option>
                            <?php

                            do {
                                $seleccionado = '';
                                $id = $r_catego["id_catego"];
                                $nombre = $r_catego["cat_catego"];
                                if ($id == $curCatego) {
                                    $seleccionado = "selected";
                                }
                                echo "<option value = '$id' $seleccionado >$nombre</option>";
                            } while ($r_catego = mysqli_fetch_assoc($q_catego));
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file">Imagen del curso:</label>
                        <input type="file" name="file" class="form-control-file" accept="image/x-png, image/jpeg, image/gif ">
                    </div>
                    <div class="form-group">
                        <label for="fileVideo">V??deo introductorio del curso:</label>
                        <input type="file" name="fileVideo" class="form-control-file" accept="video/* " >
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <?php
                            $esGratis = '';
                            if ($gratis != 0) $esGratis = '';
                            ?>
                            <input type="checkbox" checked class="custom-control-input" id="switch1" value="1" onclick="mostrarop(this)">
                            <label class="custom-control-label" for="switch1">Curso de pago?</label>
                        </div>
                    </div>
                    <div class="form-group campos-opcional-2" id="opcional">
                        <label for="costo">Costo del Curso:</label>
                        <input type="number" name="costo" class="form-control" placeholder="Costo del curso (0 = gratis xs)" value="<?php echo $costo; ?>">
                    </div>
                    <div class="form-group">
                        <label for="descri">Descripccion del Curso:</label>
                        <textarea name="descri" cols="30" rows="8" class="form-control" placeholder="breve descripcion del curso">
<?php echo $curDescri; ?>
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <a href="javascript:void(0)" id="mostrar">Mostrar campos iniciales</a>
                </div>

                <div class="form-group">
                    <label for="categoria">Subir materiales del curso</label>
                    <input type="file" class="form-control" id="docs[]" name="docs[]" accept="application/pdf" multiple="true">
                </div>
                <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
                <a href="./gestclases.php?apo=<?php echo $curCodigo; ?>&idp=<?php echo $idProfe ?>&nomc=<?php echo $curName ?>" class="btn btn-info" name="ver">Gestionar Clases</a>
                <a href="./verevas.php?apo=<?php echo $curCodigo ?>&idp=<?php echo $idProfe ?>&nomc=<?php echo $curName ?>" class="btn btn-info" name="ver">Ver Evaluaciones</a>
                <a href="./vermateriales.php?apo=<?php echo $curCodigo ?>&idp=<?php echo $idProfe ?>&nomc=<?php echo $curName ?>" class="btn btn-info" name="ver">Ver materiales</a>
                <a href="./neweva.php?apo=<?php echo $curCodigo; ?>&idp=<?php echo $idProfe ?>&nomc=<?php echo $curName ?>" class="btn btn-info" name="ver">Crear evaluaci??n</a>

            </form>
        </div>
    </div>
    
     <hr>

    <div class="row">

        <div class="col-12">
            <h3>Estad??sticas</h3>

            <h4>Usuarios Matriculados: <?php echo $nMatriculas; ?></h4>
            
        </div>


       


    </div>
    
</div>

<script>
    var mostrar = document.getElementById('mostrar');
    var campos = document.getElementById('campos');


    $(document).ready(function() {
        if ($('#switch1').is(':checked')) {
            opcional.style.display = 'block';
        }
    })


    mostrar.onclick = function() {
        campos.style.display = 'block';

    }

    var pago = document.getElementById('switch1');
    var opcional = document.getElementById('opcional');

    function mostrarop(obj) {
        if (obj.checked == true) {
            opcional.style.display = 'block';
        } else {
            opcional.style.display = 'none';
        }
    }
</script>