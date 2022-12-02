<!-- BEGIN: studentlist -->
    <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="w100">{LANG.stt}</th>
                <th>{LANG.fullname}</th>
                <th class="w100">{LANG.birthday}</th>
                <th class="w100">{LANG.sex}</th>
                <th class="w100">{LANG.class}</th>
                <th class="w100">{LANG.numberabsent}</th>
                <th class="w200">{LANG.avatar}</th>
                <th class="w200 text-center">{LANG.func}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td>{DATA.stt}</td>
                <td class="text-center">{DATA.hoten}</td>
                <td>{DATA.ngaysinh}</td>
                <td>{DATA.gioitinh}</td>
                <td>{DATA.tenlop}</td>
                <td>{DATA.sotietnghi}</td>
                <td class="text-center">
                    <img src="{DATA.anhdaidien}" class="content-image" height="100" width="75">
                </td>
                <td class="text-center">
                    <a href="{DATA.url_edit}" class="btn btn-default btn-xs"><i class="fa fa-fw fa-edit"></i>{GLANG.edit}</a>
                    <a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="nv_del_content({DATA.malop}, '{DATA.checksess}')"><i class="fa fa-fw fa-trash"></i>{GLANG.delete}</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
    <div class="form-group">
    <a href="{PAGE_ADDSTUDENT}" class="btn btn-primary">{LANG.add}</a>
</div>
</div>
<!-- END: studentlist -->
