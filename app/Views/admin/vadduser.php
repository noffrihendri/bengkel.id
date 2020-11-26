    <?= $this->extend('tempadmin'); ?>

    <?= $this->section('content'); ?>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                        <h3 class="card-title">Add user</h3>


                    </div>
                    <div class="card-header">


                        <form class="form" id="formuser" method="post" enctype="multipart/form-data" action="<?= base_url(); ?>/admin/adduser">
                            <?= csrf_field(); ?>
                            <?= $validation->listErrors(); ?>
                            <input type="text" hidden name="id" value="<?php echo isset($user) ? $user['userid'] : '' ?>" id="id">
                            <div class="form-group row">
                                <div class="col-sm-8">
                                    <div class="alert"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-2 col-form-label">username</label>
                                <div class="col-sm-6">
                                    <input type="name" name="name" class="form-control" id="username" required value="<?php echo isset($user) ? $user['username'] : '' ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-2 col-form-label">email</label>
                                <div class="col-sm-6">
                                    <input type="email" name="email" class="form-control" id="email" required value="<?php echo isset($user) ? $user['email'] : '' ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-2 col-form-label">Phonenumber</label>
                                <div class="col-sm-6">
                                    <input type="text" name="Phonenumber" class="form-control" id="Phonenumber" required value="<?php echo isset($user) ? $user['nomer'] : '' ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-6">
                                    <input type="password" name="Password" class="form-control" id="Password" required value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-2 col-form-label">Repassword</label>
                                <div class="col-sm-6">
                                    <input type="password" name="Repassword" class="form-control" id="Repassword" required value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabel" class="col-sm-2 col-form-label">role</label>
                                <div class="col-sm-6">
                                    <select id="role" class="form-control" name="role" required>
                                        <option>Choose...</option>

                                        <?php
                                        foreach ($role as $role) {
                                            $selected = "";
                                            if (isset($user)) {
                                                if ($user['user_role'] == $role['role_id']) {
                                                    $selected = "selected";
                                                }
                                            }

                                        ?>
                                            <option value="<?php echo $role['role_id'] ?>" <?= $selected ?>><?php echo $role['role_name']    ?></option>
                                        <?php     }
                                        ?>



                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch3" name="is_active">
                                    <label class="custom-control-label" for="customSwitch3">is active</label>
                                </div>
                            </div>


                            <div class="form-group">

                                <button type="submit" class="btn btn-md btn-primary">Submit</button>
                                <button type="reset" class="btn btn-md btn-danger">Cancel</button>
                            </div>


                        </form>


                    </div>
                </div>
                <!-- /.card -->


            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

    <script>
        // $("#formuser").submit(function(e) {
        //     e.preventDefault();

        //     ///crf token
        //     var csrfName = '<?= csrf_token() ?>',
        //         csrfHash = '<?= csrf_hash() ?>';

        //     form_data = {
        //         id: $("#id").val(),
        //         username: $("#username").val(),
        //         email: $("#email").val(),
        //         nomer: $("#Phonenumber").val(),
        //         nomer: $("#Password").val(),
        //         nomer: $("#Repassword").val(),
        //         role: $("#role").val(),
        //         isactive: $('#customSwitch3').is(":checked"),
        //         [csrfName]: csrfHash
        //     }

        //     console.log(form_data);

        //     $.ajax({
        //         url: "<?= base_url(); ?>/Home/adduser",
        //         data: form_data,
        //         type: 'post',
        //         dataType: 'JSON',
        //         headers: {
        //             'api-key': 'myKey'
        //         },
        //         error: function(err) {
        //             alert('terjadi kesalahan pada sisi server!', 'error');
        //         },
        //         success: function(data) {
        //             if (data.valid) {
        //                 $('.alert').html('<div class="alert alert-success" role="alert">' + data.msg + '</div>');
        //                 document.getElementById("formuser").reset();
        //             } else {
        //                 $('.alert').html('<div class="alert alert-danger" role="alert">' + data.msg + '</div>');
        //             }
        //         }
        //     })

        // });
    </script>


    <?= $this->endsection(); ?>