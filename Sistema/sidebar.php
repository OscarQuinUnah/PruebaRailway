<?php 
//Controladores importantes
 require '../../conexion_BD.php';     
 $usuario=$_SESSION['user'];
 $ID_Rol=$_SESSION['ID_Rol'];
?>

<section class="full-box cover dashboard-sideBar" style="overflow-y: auto;">
		<div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
		<div class="full-box dashboard-sideBar-ct">
			<!--Muestra el titulo de la barra lateral-->
			<div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
				Creo en ti <i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
			</div>
			<!-- Informacion de usuario de la barra lateral -->
			<div class="full-box dashboard-sideBar-UserInfo">
				<figure class="full-box">
					<img src="../../img/avatar.jpg" alt="UserIcon">
					<figcaption class="text-center text-titles"><?php echo $usuario; ?></figcaption>
				</figure>
				<ul class="full-box list-unstyled text-center">
					<li>
						<a href="../conf/gestion.php">
							<i class="zmdi zmdi-settings"></i>
						</a>
					</li>
					<li>
					    <a class="btn-exit-system">
							<i class="zmdi zmdi-power"></i>
						</a>
					</li>
				</ul>
			</div>
			<!-- Menu de la barra lateral -->
			<?php $sql=$conexion->query("SELECT * FROM tbl_ms_roles where ID_Rol=$ID_Rol and Estado=1");
if ($datos=$sql->fetch_object()) { ?>
			<ul class="list-unstyled full-box dashboard-sideBar-Menu">
			<?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Estad=1 and ID_Rol=$ID_Rol and ID_Objeto=16");
if ($datos=$sql->fetch_object()) { ?>
			<li>
					<a href="../Home/home.php">
						<i class="zmdi zmdi-home"></i> Home
					</a>
			</li>
			<?php } ?>
			<?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Estad=1 and ID_Rol=$ID_Rol and ID_Objeto=1");
if ($datos=$sql->fetch_object()) { ?>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Usuarios <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="../Usuarios/usuariosAdm.php"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Mantenimiento usuarios</a>
						</li>
					</ul>
				</li>
				<?php } ?>
				<?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Estad=1 and ID_Rol=$ID_Rol and (ID_Objeto = 12 OR ID_Objeto = 2 OR ID_Objeto = 3 OR ID_Objeto = 4 OR ID_Objeto = 5 OR ID_Objeto = 18)");
if ($datos=$sql->fetch_object()) { ?>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-shield-security zmdi-hc-fw"></i> Seguridad <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
					<?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Estad=1 and ID_Rol=$ID_Rol and ID_Objeto=12");
if ($datos=$sql->fetch_object()) { ?>
					    <li>
							<a href="../Seguridad/Backups_BD.php"><i class="zmdi zmdi-folder-outline"></i> Backups </a>
						</li>
						<?php } ?>
						<?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Estad=1 and ID_Rol=$ID_Rol and ID_Objeto=2");
if ($datos=$sql->fetch_object()) { ?>
						<li>
							<a href="../Seguridad/bitacora.php"><i class="zmdi zmdi-assignment-o"></i> Bitacora </a>
						</li>
						<?php } ?>
						<?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Estad=1 and ID_Rol=$ID_Rol and ID_Objeto=3");
if ($datos=$sql->fetch_object()) { ?>
						<li>
							<a href="../seguridad/ParametrosAdm.php"><i class="zmdi zmdi-archive"></i> Parametros </a>
						</li>
						<?php } ?>
						<?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Estad=1 and ID_Rol=$ID_Rol and ID_Objeto=4");
if ($datos=$sql->fetch_object()) { ?>
						<li>
							<a href="../seguridad/PreguntasAdm.php"><i class="zmdi zmdi-view-list"></i> Preguntas </a>
						</li>
						<?php } ?>
						<?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Estad=1 and ID_Rol=$ID_Rol and ID_Objeto=5");
if ($datos=$sql->fetch_object()) { ?>
						<li>
							<a href="../seguridad/RolesAdm.php"><i class="zmdi zmdi-face"></i> Roles </a>
						</li>
						<?php } ?>
						<?php $sql=$conexion->query("SELECT * FROM tbl_permisos where  Estad=1 and ID_Rol=$ID_Rol and ID_Objeto=18");
if ($datos=$sql->fetch_object()) { ?>
						<li>
							<a href="../seguridad/ObjetosAdm.php"><i class="zmdi zmdi-money-box"></i>Objetos </a>
						</li>
						<?php } ?>
					</ul>
				</li>
				<?php } ?>
				<?php $sql=$conexion->query("SELECT * FROM tbl_permisos where Estad=1 and ID_Rol=$ID_Rol and ID_Objeto=11");
if ($datos=$sql->fetch_object()) { ?>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-money"></i> SAR <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="../SAR/SAR_Adm.php"><i class="zmdi zmdi-file zmdi-hc-fw"></i> Mantenimiento SAR </a>
						</li>
					</ul>
				</li>
				<?php } ?>
				<?php $sql=$conexion->query("SELECT * FROM tbl_permisos where  Estad=1 and ID_Rol=$ID_Rol and ID_Objeto=6");
if ($datos=$sql->fetch_object()) { ?>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-folder-star"></i> Proyectos <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="../proyectos/proyectosAdm.php"><i class="zmdi zmdi-markunread-mailbox"></i> Mantenimiento Proyectos </a>
						</li>
					</ul>
				</li>
				<?php } ?>
			</ul>
			<?php } ?>
		</div>
	</section>

    <!--script en java para los efectos-->
	<script src="../../js/sweetalert2.min.js"></script>