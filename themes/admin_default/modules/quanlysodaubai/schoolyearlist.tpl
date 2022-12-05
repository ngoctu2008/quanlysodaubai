<!-- BEGIN: schoolyearlist -->
   <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="w200">{LANG.schoolyear}</th>
                <th>{LANG.starttime}</th>
                <th>{LANG.finishtime}</th>
                <th class="w300 text-center">{LANG.func}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td>{DATA.namhoc}</td>
                <td>{DATA.thoigianbatdau}</td>
                <td>{DATA.thoigianketthuc}</td>
                <td class="text-center">
                    <a href="{DATA.url_weeklist}" class="btn btn-default btn-xs"><i class="fa fa-fw fa-list"></i>{LANG.weeklist}</a>
                    <a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="nv_del_schoolyear({DATA.manamhoc}, '{DATA.checksess}')"><i class="fa fa-fw fa-trash"></i>{GLANG.delete}</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
    <div class="form-group">
    <a href="{PAGE_ADDSCHOOLYEAR}" class="btn btn-primary">{LANG.add}</a>
    </div>
</div>
<!-- END: schoolyearlist -->
