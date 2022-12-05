<!-- BEGIN: weeklist -->
   <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center">{LANG.weekname}</th>
                <th class="text-center">{LANG.fromday}</th>
                <th class="text-center">{LANG.today}</th>
                <th class="text-center">{LANG.schoolyear}</th>
                <th class="w250 text-center">{LANG.desc}</th>
                <th class="text-center">{LANG.validate}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class=text-center>{DATA.tentuan}</td>
                <td class=text-center>{DATA.tungay}</td>
                <td class=text-center>{DATA.denngay}</td>
                <td class=text-center>{DATA.namhoc}</td>
                <td class=text-center>
                     {DATA.mota}
                    <a href="{DATA.url_edit}" class="btn btn-default btn-xs" ><i class="fa fa-fw fa-{DATA.icon}"></i></a>
                </td>
                <td class="text-center">
                    <input type="checkbox" name="activecheckbox" id="change_active_week_{DATA.matuan}" onclick="nv_change_active_week('{DATA.matuan}')" {DATA.active}>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>
<!-- END: weeklist -->
