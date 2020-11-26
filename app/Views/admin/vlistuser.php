    <?= $this->extend('tempadmin'); ?>

    <?= $this->section('content'); ?>

    <script>
        $(document).ready(function() {

            var table = $('.datatable').DataTable({
                "serverSide": true,
                "processing": true,
                language: {
                    searchPlaceholder: "Search By Username"
                },
                "ajax": {
                    url: "<?= base_url("admin/datauser") ?>",
                    type: "GET"
                }
            });

        });
    </script>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List User</h3>
                    </div>

                    <div class="card-header">
                        <a type="button" href="<?= base_url(); ?>/admin/vadduser" class="btn btn-primary">tambah User</a>


                    </div>

                    <div class="box">
                        <div class="box-header">
                        </div>
                        <div class="box-body">



                        </div>



                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phonenumber</th>
                                        <th>Email</th>
                                        <th>Akses</th>
                                        <th>Created Date</th>
                                        <th>Is_active</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>




                                </tbody>

                            </table>
                        </div>







                    </div>
                    <!-- /.card -->


                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
    </section>
    <!-- /.content -->

    <?= $this->endsection(); ?>