<!-- BEGIN: subjectlist -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="w100">{LANG.stt}</th>
                <th class="w100">{LANG.subject}</th>
                <th class="w200 text-center">{LANG.func}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td>{DATA.stt}</td>
                <td>{DATA.tenmonhoc}</td>
                <td class="text-center">
                    <a href="{DATA.url_edit}" class="btn btn-default btn-xs"><i class="fa fa-fw fa-edit"></i>{GLANG.edit}</a>
                    <a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="nv_del_subject({DATA.mamonhoc}, {DATA.checkss})"><i class="fa fa-fw fa-trash"></i>{GLANG.delete}</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
    <div class="form-group">
        <a href="{PAGE_ADDSUBJECT}" class="btn btn-primary">{LANG.add}</a>
    </div>
</div>
<script>
    function nv_del_subject(subjectid, checkss) {
        if (confirm(nv_is_del_confirm[0])) {
            $.post(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=delsubject&nocache=' + new Date().getTime(), 'subjectid=' + subjectid + '&checkss=' + checkss, function(res) {
                var r_split = res.split("_");
                if (r_split[0] == 'OK') {
                    window.location.href = script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=subjectlist';
                } else if (r_split[0] == 'ERR') {
                    alert(r_split[1]);
                } else {
                    alert(nv_is_del_confirm[2]);
                }
            });
        }
        return false;
    }
</script>
<!-- END: subjectlist -->
