<!-- BEGIN: configclassdiagram -->
<div class="container-fluid">
    <h2>Danh sach hoc sinh</h2>
    <form action="" method="post">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <th>{LANG.fullname}</th>
                <th>{LANG.chon}</th>
            </thead>
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td style="font-size: 18px;">
                        {DATA_CONFIG.hoten}
                    </td>
                    <td>
                    <input type="submit" name="submit" value="{LANG.chon}" class="btn btn-primary" />  
                    </td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>

    </form>

</div>
<!-- END: configclassdiagram -->