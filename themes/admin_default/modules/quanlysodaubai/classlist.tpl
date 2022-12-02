<!-- tham khảo từ quản lý thăm dò (thăm dò ý kiến) -->
<!-- BEGIN: classlist -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="w100">{LANG.classid}</th>
                <th>{LANG.classname}</th>
                <th class="w400">{LANG.homeroomteacher}</th>
                <th class="w100">{LANG.unit}</th>
                <th class="w300 text-center">{LANG.func}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center">{DATA.malop}</td>
                <td>{DATA.tenlop}</td>
                <td>{DATA.teacher}</td>
                <td>{DATA.khoi}</td>
                <td class="text-center">
                    <a href="{DATA.url_studentlist}" class="btn btn-default btn-xs"><i class="fa fa-fw fa-list"></i>{LANG.liststudent}</a>
                    <a href="{DATA.url_edit}" class="btn btn-default btn-xs"><i class="fa fa-fw fa-edit"></i>{GLANG.edit}</a>
                    <a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="nv_del_class({DATA.malop}, '{DATA.checksess}')"><i class="fa fa-fw fa-trash"></i>{GLANG.delete}</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
    <div class="form-group">
    <a href="{PAGE_ADDCLASS}" class="btn btn-primary">{LANG.add}</a>
</div>
</div>
<!-- END: classlist -->
