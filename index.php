<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>tabla</title>
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="css/chat.css">
</head>

<?php
include ("cls/clsConexion.php");

$DbConect = new ConexionSQL();

$tabla_cliente = "dialogos_dirigidos";

$id = isset($_REQUEST['id'])?$_REQUEST['id']:null;
$btn = isset($_REQUEST['btn'])?$_REQUEST['btn']:null;
$frase = isset($_REQUEST['frase'])?$_REQUEST['frase']:null;
$script = isset($_REQUEST['script'])?$_REQUEST['script']:null;

switch ($btn) {
    case 'agregar':
        $sql = "INSERT INTO ".$tabla_cliente." (frase,script) VALUES('".$frase."',".$script.")";
        $res3 = $DbConect->Consulta($sql);
        if($res3){
            echo "hay frases activas";
            ?>
                <div class="miAlerta alert alert-success" role="alert" id="alert_success"><span>Frase creada correctamente.</span><button type="button" class="close">&times;</button></div>
            <?php
        }else{
            ?>
                <div class="float alert alert-danger" role="alert"><span>Error al crear la frase.</span></div>
            <?php
        }    
        break;
    case 'editar':
        $sql = "SELECT * FROM ".$tabla_cliente." WHERE id = '".$id."'";
        $res3 = $DbConect->Consulta($sql);
        $form = $DbConect->ExtraerDatos($res3);
        $frase = $form['frase'];
        $script = $form['script'];

        break;

    case 'actualizar':
        $sql = "UPDATE ".$tabla_cliente." SET frase='".$frase."', script=".$script." WHERE id='".$id."'";
        $res3 = $DbConect->Consulta($sql);
        if($res3){
            $frase='';
            $script='';
            echo "Actualizado con exito";
        ?>
            <div class="miAlerta alert alert-success" role="alert" id="alert_warning"><span>Frase Actualizada Correctamente.</span><button type="button" class="close">&times;</button></div>
        <?php
        }else{
            ?>
                <div class="float alert alert-danger" role="alert"><span>Error al Actualizar Frase.</span></div>
            <?php
        }

        break;
    case 'X':
        $sql = "DELETE FROM ".$tabla_cliente." WHERE id='".$id;
        $res3 = $DbConect->Consulta($sql);
        
        if($DbConect->FilasAfectadas() > 0){
            ?>
                <div class="miAlerta alert alert-success" role="alert" id="alert_warning"><span>Frase Eliminada.</span><button type="button" class="close">&times;</button></div>
            <?php
        }else{
            ?>
                <div class="float alert alert-danger" role="alert"><span>Error al eliminar la frase.</span></div>
            <?php
        }    
        break;
    
    case 'activar':
        $sql = "SELECT * FROM ".$tabla_cliente." WHERE status='S'";
        $res3 = $DbConect->Consulta($sql);
        if( $DbConect->nroreg($res3) > 0){
            echo "hay frases activas por lo que no se puede activar dos al mismo tiempo";

            ?>
                <div class="miAlerta alert alert-danger" role="alert" id="alert_warning"><span>Hay Frases Activas aun no se puede activar dos... </span><button type="button" class="close">&times;</button></div>
            <?php
        }else{
            $sql = "UPDATE ".$tabla_cliente." SET status='S' WHERE id = '".$id;
            $res3 = $DbConect->Consulta($sql);
            if($res3){
                echo "Actulizado con exito";
            ?>
                <div class="miAlerta alert alert-success" role="alert" id="alert_warning"><span>Frase Activada Correctamente.</span><button type="button" class="close">&times;</button></div>
            <?php
            }else{
                ?>
                    <div class="float alert alert-danger" role="alert"><span>Error al Activar Frase.</span></div>
                <?php
            }   
        }    
        break;
    case 'desactivar':
        $sql = "UPDATE ".$tabla_cliente." SET status='N' WHERE id = ".$id;
        $res3 = $DbConect->Consulta($sql);
        if($DbConect->FilasAfectadas()>0){
            echo "Actualizado con exito";
            ?>
                <div class="miAlerta alert alert-success" role="alert" id="alert_warning"><span>Frase Desactivada Correctamente.</span><button type="button" class="close">&times;</button></div>
            <?php
        }else{
            ?>
                <div class="float alert alert-danger" role="alert"><span>Error al Desactivar Frase.</span></div>
            <?php
        }    
        break;
    default:
        # code...
        break;
}


?>
<body style="background:rgb(48, 48, 48); color: white;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-5">
                <div class="row">
                    <h1>Creación de nuevas frases</h1>
                </div>
                <div class="row">
                    <form action="index.php" method="post">
                        <div class="row">
                            <div class="container-fluid form-group">
                                            <div class="row">
                                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                <div class="col-2">
                                                    Dialogo
                                                </div> 
                                                <div class="col-10">
                                                    <input class="form-control" type="text" name='frase' value="<?php echo $frase; ?>">
                                                </div>
                                            </div>
                            </div>
                            <div class="container-fluid form-group">
                                            <div class="row">
                                                <div class="col-2"><p>Scripts</p></div>
                                                <div class="col-10">
                                                    <select class="form-control" name='script'>
                                                        <?php 
                                                        $sql = "SELECT id,nombre FROM scripts WHERE status = 'S'";
                                                        $res1 = $DbConect->Consulta($sql);
                                                        if($res1){
                                                            while($opt = $DbConect->ExtraerDatos($res1)){
                                                                $x= "";
                                                                if($script==$opt['script']){
                                                                    $x="selected";
                                                                }
                                                                ?>
                                                                
                                                                <option value="<?php echo $opt['id']; ?>" $x><?php echo $opt['nombre']; ?></option>

                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>    
                            </div>

                        </div>                    
                        <div class="text-right">    
                            <?php  if($btn!="editar"){  ?>
                                <button id="boton" class="btn btn-primary" name="btn" value="agregar" type="submit">Crear frase</button>
                            <?php }else{ ?>
                                <button id="boton" class="btn btn-success" name="btn" value="actualizar" type="submit">Actualizar frase</button>
                            <?php } ?> 
                        </div>
                    </form>
                </div>
                <div class="chatbox overflow-auto" id="chatbox"> 
                        <div class="chatbox mensage left row">
                            <img class="chatbox img left" src="images/usuarios.png" alt="avatarUser">
                            <p>hola robot... como estas tu? </p>
                            <span class="time-right"> 11:00</span>
                        </div>
                        <div class="chatbox mensage right row" style="display: flex; justify-content: flex-end">
                                <p>chevere! yo me encuentro genial! </p>
                                <span class="time-right"> 11:02</span>
                                <img class="chatbox img right" src="images/pbot.png" alt="AvatarRobot">
                        </div>
                        <div class="chatbox mensage left row">
                            <img class="chatbox img left" src="images/usuarios.png" alt="avatarUser">
                            <p>me alegra escucharlo </p>
                            <span class="time-right"> 11:00</span>
                        </div>
                        <div class="chatbox mensage right row" style="display: flex; justify-content: flex-end">
                                <p>gracias me gusta hablar contigo </p>
                                <span class="time-right"> 11:02</span>
                                <img class="chatbox img right" src="images/pbot.png" alt="AvatarRobot">
                        </div>
                </div>
                <div class="container">
                        <div class="row">
                            <div class="col-10">
                                <input class="form-control" type="text" name='chat' value="">
                            </div>
                            <div class="col-2">    
                                <div class="text-right"><button id="botonchat" class="btn btn-success" name="btn" value="chat" type="submit">Chat</button></div>
                            </div>
                        </div>
                </div>      
            </div>    
            <div class="col-7">
                <h1>Frases actuales</h1>
                <div class="table-responsive" style="overflow: auto;" id="ListaDialogos">
                    lista de contenido
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(function(){ 
                VerLista();
            }, 1000);


            function VerLista(){
                $.ajax({
                        async:true,
                        type:"POST",
                        cache: false,
                        success: function (data) {
                            $("#ListaDialogos").html(data);
                        },
                        error: function() {
                            $("#ListaDialogos").html("<center><h1>Error al Cargar Lista</h1><center>");
                        },
                        beforeSend: function(){
                            $("#ListaDialogos").html("<center><br><br><img src='images/loading.gif'><center>");
                        },
                        url: './lista_dialogos.php'
                });
            }

        });  
    </script>
</body>

</html>
