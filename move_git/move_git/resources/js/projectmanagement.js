var projectMangement = (function($){

    var $self = this;
    var msgDefinition = {
      requiredField: 'Thiếu thông tin bắt buộc.',
        jointStaff: 'Đã có nhân viên/nhóm này trong danh sách.',
        sucProjectCreation: 'Tạo dự án thành công.'

    };
    var errorMsgDefinition = {
        pathProjectInvalid: 'Đường dẫn dự án không hợp lệ. Vui lòng chọn lại đường dẫn',
    };

    var projectInfoModel = {
        id: '',
        customer_id: '',
        customer_name: '',
        project_id: '',
        project_name:'',
        status: '',
        project_path: '',
    };
    var adminModel = {
        working_factor_i: '',
        working_factor_ii: '',
        working_factor_iii: '',
        team_manager: '1',
        project_manager: '1',

    };
    /**
     * 2020\AYT\AYT2002-001 2800331-1 Barashi Part SHIKOKU 0204
     * 
     * Khach Hang: 2020
     * Ma du an: AYT2002-001
     * Ten du an: 2800331-1 Barashi Part SHIKOKU 0204
     */
    $self.changeProjectFolder = function(e){
        // 2020\ACT\ACT2009\ACT2010-001
        // YYYY\KhanhHang\KhachHangYYMM\KhachHangYYMM-STT OF Month
        // \\172.16.100.16\ProjectFolder\2020\ACT\ACT2009\ACT2009-002 BWTYU20 487
        var str = $(e.currentTarget).val();
        if(!str){
            $('#customer-id').val('');
            $('#project-id').val('');
            $('#project-name').val('');
            return;
        } 
        var res = str.split("\\");
        var length = res.length;
        if(length < 3){
            errorMsg = [];
            errorMsg.push(errorMsgDefinition.pathProjectInvalid);
            notification.showWarning(errorMsg);
            return;
        }
        var customerName = res[length - 3];
        for(var i = 0; i < metaData.customerList.length ; i++){
            if(metaData.customerList[i].customer_id == customerName){
                projectInfoModel.customer_id = metaData.customerList[i].id;
                projectInfoModel.customer_name = customerName;
                break;
            }
            
        }
        if(i == metaData.customerList.length){
            projectInfoModel.customer_id = '';
        }
        projectInfoModel.project_id = res[length - 1].split(' ')[0];
        projectInfoModel.project_name = res[length - 1].substring(12);
        $('#customer-id').val(projectInfoModel.customer_id);
        $('#project-id').val(projectInfoModel.project_id);
        $('#project-name').val(projectInfoModel.project_name);
        if(!projectInfoModel.customer_id 
            || !projectInfoModel.project_id
            || !projectInfoModel.project_name){
            errorMsg = [];
            errorMsg.push(errorMsgDefinition.pathProjectInvalid);
            notification.showWarning(errorMsg);
        }
    }

    $self.createProjectInformation = function(e){
        for(var attr in projectInfoModel){
            var idString = attr.replace(/_/gi, "-");
            var element = $('#'+idString);
            if(element.length){
                projectInfoModel[attr] = element.val();
            }
        }
        for(var attr in adminModel){
            var idString = attr.replace(/_/gi, "-");
            var element = $('#'+idString);
            if(element.length){
                adminModel[attr] = element.val();
            }
        }

        var valid = _validateProjectData();
        if(!valid){
            errorMsg = [];
            errorMsg.push(msgDefinition.requiredField);
            notification.showWarning(errorMsg);
            return;
        }

        var action = '/application/api/v1/quan-ly-du-an';
        var data = {
          projectInfo: projectInfoModel,
            admin: adminModel,
            jointStaffList: _getJointStaffList()
        };
        http.post(data, action, function(data, textStatus, jqXHR ) {
            if(data.error.length){
                notification.showWarning(data.error);
            }else if(data.message.length){
                notification.showWarning(data.message);
                setTimeout(function(){ 
                    resolve(data);
                }, 3000);
            }else{
                var messageList = [];
                messageList.push(msgDefinition.sucProjectCreation);
                notification.showSuccess(messageList);
                location.reload();
            }
        });
    };

    $self.selectManager = function(e, type){
        var val = $(e.currentTarget).val();
        switch (type){
            case "TeamManager":
                $('input[name="team_manager"]').val(val);
                $('select#team_manager_name').val(val);
                $('select#team_manager_id').val(val);
                break;
            case "ProjectManager":
                $('input[name="project_manager"]').val(val);
                $('select#project_manager_name').val(val);
                $('select#project_manager_id').val(val);
                break;
            default:
                return;
        }
    };

    $self.addTeam = function(){
        var teamVal = $("select#project_team").val();
        var staffInTeam = jointStaff.staffInTeam[teamVal];
        if(staffInTeam){
            staffInTeam.forEach(_addRowToJointStaffTable);
        }

    };

    $self.addStaff = function(e){
        var staffVal = $("select#project_staff").val();
        jointStaff.staffList.forEach(function(staff) {
            if(staff.id == staffVal){
                _addRowToJointStaffTable(staff, null);
            }
        });
    };

    $self.deleteStaff = function(e, staffId){
        $("table tbody").find('input[name="record"]').each(function(){
            if($(this).is(":checked")){
                $(this).parents("tr").remove();
            }
        });

        $(document).delegate('a.delete-record', 'click', function(e) {
            e.preventDefault();
            var didConfirm = confirm("Are you sure You want to delete");
            if (didConfirm == true) {
                var id = $(this).attr('data-id');
                var targetDiv = $(this).attr('targetDiv');
                $('#rec-' + id).remove();

                //regnerate index number on table
                $('#tbl_posts_body tr').each(function(index) {
                    //alert(index);
                    $(this).find('span.sn').html(index+1);
                });
                return true;
            } else {
                return false;
            }
        });
    };

    $(document).delegate('a.add-record', 'click', function(e) {
        e.preventDefault();
        var content = $('#sample_table tr'),
            size = $('#tbl_posts >tbody >tr').length + 1,
            element = null,
            element = content.clone();
        element.attr('id', 'rec-'+size);
        element.find('.delete-record').attr('data-id', size);
        element.appendTo('#tbl_posts_body');
        element.find('.sn').html(size);
    });

    // $('#project-list-frame li.list-group-item').on('click', function (e) {
    //     e.preventDefault()
    //     $(this).addClass('active');
    //   });

    //   $(document).on('click', '#project-list-frame li.list-group-item' , function(e) {
    //     e.preventDefault();
    //     $('#project-list-frame li.list-group-item.active').removeClass('active');
    //     $(this).addClass('active');
    // });
    function _addRowToJointStaffTable(data, index){
        var jointStaffList = _getJointStaffList();
        if(jointStaffList.indexOf(data['id']) !== -1){
            errorMsg = [];
            errorMsg.push(msgDefinition.jointStaff);
            notification.showWarning(errorMsg);
            return;
        }

        var idStaff = data['id'];
        var inputIdStaff = '<input class="staff-id" hidden value="'+ idStaff +'" />';
        var staffId = data['staff_id'];
        var name = data['short_name'];
        var team = data['team'];
        var markup = "<tr>" +
            "<td>" + staffId + inputIdStaff + "</td>" +
            "<td>" + name + "</td>" +
            "<td>" + team + "</td>" +
            "<td>"+ '<button type="button" class="btn btn-danger btn-icon">x</button>' +"</td>" +
            "</tr>";
        $("table#joint-staff-table tbody").append(markup);
    }

    function _getJointStaffList(){
        var jointStaffList = [];
        $('table#joint-staff-table tr').each(function(index) {
            var staffId = $(this).find('input.staff-id').val();
            if(staffId){
                jointStaffList.push(parseInt(staffId));
            }

        });
        return jointStaffList;

    }

    function _validateProjectData(){
        var valid = true;
        if(!projectInfoModel.customer_id) return false;
        if(!projectInfoModel.project_id) return false;
        if(!projectInfoModel.project_name) return false;
        if(!projectInfoModel.status) return false;
       // if(!projectInfoModel.project_path) return false;

        return valid;

        if (!Directory.Exists(fTaoDuAn.tbxDuongDan.Text))
        {
            MessageBox.Show("Đường dẫn dự án không tồn tại hoặc không thể truy cập!", "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            return false;
        }
    }

    return $self;

})(jQuery);

