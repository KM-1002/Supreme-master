<link rel="stylesheet" type="text/css" href="CSS/login.css">

<li><a title="Đăng nhập" onclick="document.getElementById('id01').style.display='block'"><img src="IMG/login.png"></a></li>
<?php include './fbsource.php'; ?>

<div id="id01" class="modal">
	<form class="modal-content animate" name="sub" action="" method="post">
		<div class="imgcontainer">
			<span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
			<img src="IMG/829d15f2c100855d085e46ebe3d9569a.png" img_avatar2.png"" alt="Avatar" class="avatar">
		</div>
		<div class="container">
			<label for="uname"><b>Tên đăng nhập</b></label>
			<input type="text" placeholder="Nhập tên đăng nhập" name="text_user" id="username" required>
			<label for="psw"><b>Mật khẩu</b></label>
			<input type="password" placeholder="Nhập mật khẩu" name="text_passwd" id="password" required>
			<button type="submit" name="log" id="login">Đăng nhập</button>
			<button class="loginfb" onclick="location.href='<?= $loginUrl ?>'">Đăng nhập bằng facebook</button>
		</div>

		<div class="container" style="background-color:#232323">
			<button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Thoát</button>
			<span class="psw"><a class="tao-tk" style="font-size: 15px;height: 40px;margin-top: 8px;background:#BF0003;color:#FFFFFF;" href="register.php">Tạo tài khoản</a></span>
		</div>
	</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script>
        $(document).ready(function()
        {
            $('#login').click(function(e)
                {
                    e.preventDefault(); 
                    var $username = $('#username').val();
                    var $password = $('#password').val();
                    
                    $.ajax
                    ({
                        url: 'xuly_dangnhap.php',
                        type: 'post', //post và get
                        dataType: 'html',
                        data: {
                            user : $username,
                            pass : $password
                        }
                    }).done(function(ketqua)
                    {
                        if(ketqua==1){
                            location.reload();
                        }
                        else if(ketqua==2){
                            alert('Sai tài khoản hoặc mật khẩu');

                        }
                    });

                });
        });
    </script>