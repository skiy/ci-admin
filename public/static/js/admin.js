$(function () {

    //login
    $('#login-form-cli').on('click', function () {
        let account = $('#account').val();
        let password = $('#password').val();

        if ('' == account) {
            swal('', '请输入帐号', 'error');
            return false;
        }

        if ('' == password) {
            swal('', '请输入密码', 'error');
            return false;
        }

        //POST
        axios({
            method: 'post',
            url: '/admin.php/user/login',
            data: {
                account: account,
                password: password
            },
        })
            .then(function (response) {
                let d = response.data;
                if (d.code == 0) {
                    swal({
                        title: '登录成功',
                        text: '',
                        type: 'success',
                        timer: 1000,
                    }).then((result) => {
                        // location.reload();
                        window.location.href = '/admin.php';
                    });
                } else {
                    let msg = d.message;
                    if (typeof(msg) == 'undefined') {
                        msg = '未知错误';
                    }
                    swal('', msg, 'error');
                }
            })
            .catch(function (response) {
                //console.log(response, 2);
                swal('', '请求失败', 'error');
                return false;
            });
    });

    //modify pwd
    $('#account-modify-pwd-cli').on('click', function () {
        let password = $('#password').val();
        let password2 = $('#password2').val();

        if ('' == password) {
            swal('', '请输入新密码', 'error');
            return false;
        }

        if ('' == password2) {
            swal('', '请再次输入新密码', 'error');
            return false;
        }

        if (password != password2) {
            swal('', '两次输入的密码不匹配', 'error');
            return false;
        }

        //POST
        axios({
            method: 'post',
            url: '/admin.php/user/modify_pwd',
            data: {
                password: password,
                password2: password2,
            },
        })
            .then(function (response) {
                let d = response.data;
                if (d.code == 0) {
                    swal({
                        title: '修改密码成功',
                        text: '',
                        type: 'success',
                        timer: 1000,
                    }).then((result) => {
                        //location.reload();
                        window.location.href = '/admin.php';
                    });
                } else {
                    swal('', d.message, 'error');
                }
            })
            .catch(function (response) {
                alert(response);
                //console.log(response, 2);
                swal('', '请求失败', 'error');
                return false;
            });
    });
});