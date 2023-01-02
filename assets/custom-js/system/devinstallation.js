// BASEURL ="http://localhost/dealer_app/index.php/";


pageTable = "DevInstallationTable";
ajaxUrl = "devInstallationLogList";
formModalBox = "devInstallationLogFormModal";
addEditForm = "devInstallationLogForm";
addUrl = "addDevInstallationLog";

var somethingChanged = false;
$("input,select").change(function () {
  somethingChanged = true;
  $("#stateSubmit").attr("disabled", false);
});

function toTitleCase(str) {
  return str.replace(/(?:^|\s)\w/g, function (match) {
    return match.toUpperCase();
  });
}

function editDevInstallation(id) {
  // $('#customerSubmit').attr("disabled",false);
  $("#" + addEditForm)[0].reset();
  $("#Statusdiv").show();
  $(".help-block").hide();

  somethingChanged = false;

  var DevInstallationLogID = id;

  $.ajax({
    type: "POST",
    url: BASEURL + "editDetails",
    data: { DevInstallationLogID: DevInstallationLogID },
    dataType: "json",
    success: function (resultData) {
      console.log(resultData.data);
      if ((resultData.data.Status = "1")) {
        $("#" + formModalBox).modal("show");
        $("#VehRegNum").val(resultData.data.VehRegNum);
        $("#DeviceSr").val(resultData.data.DeviceSrNumber);
        $("#OdoCorrectionConf").val(resultData.data.OdoCorrectionConf);

        if (resultData.data.Status == 1) {
          $("#Status").attr("checked", "checked");
          $("#Status").val(1);
        } else {
          $("#Status").removeAttr("checked");
          $("#Status").val(0);
        }
        $("<input>")
          .attr({
            type: "hidden",
            id: "DevInstallationLogID",
            name: "DevInstallationLogID",
            value: DevInstallationLogID,
          })
          .appendTo("#" + addEditForm);

        $("<input>")
          .attr({
            type: "hidden",
            id: "VehID",
            name: "VehID",
            value: resultData.data.VehID,
          })
          .appendTo("#" + addEditForm);

        $("<input>")
          .attr({
            type: "text",
            id: "DeviceID",
            name: "DeviceID",
            value: resultData.data.DeviceID,
          })
          .appendTo("#" + addEditForm);
      }
    },
    error: function (error) {},
  });
}

$(document).ready(function () {


  $("#" + addUrl).click(function (e) {
    $("#" + addEditForm)[0].reset();
    $("#Statusdiv").hide();
    $("#" + formModalBox).modal("show");
    $(".help-block").hide();
    if (
      $("#DevInstallationLogID").length &&
      $("#" + addEditForm + ' input[name="DevInstallationLogID"]').val() != ""
    ) {
      $("#" + addEditForm + ' input[name="DevInstallationLogID"]').remove();
      $("#" + addEditForm)[0].reset();
    }
  });

  $("#VehRegNum").on("keyup", function (e) {
    $("#searchResult").empty();
    let veh_reg_num = $(this).val();
    $.ajax({
      method: "POST",
      url: BASEURL + "getSearch",
      data: { veh_reg_num: veh_reg_num },
      dataType: "json",
      success: function (response) {
        var len = response.length;

        $("#searchResult").empty();
        for (var i = 0; i < len; i++) {
          var veh_id = response[i]["VehID"];
          var veh_reg_num = response[i]["VehRegNum"];
          $("#searchResult").append(
            "<li value='" + veh_id + "'>" + veh_reg_num + "</li>"
          );
        }
        // binding click event to li
        $("#searchResult li").bind("click", function (e) {
          var TextVal = $(this).text();
          $("#VehRegNum").val(TextVal);
          $("#searchResult").remove();
          $("<input>")
            .attr({
              type: "hidden",
              id: "VehID",
              name: "VehID",
              value: veh_id,
            })
            .appendTo("#" + addEditForm);
        });
      },
    });
  });
  $("#DeviceSr").on("keyup", function (e) {
    $("#devResult").empty();
    let DeviceSrNumber = $(this).val();
    $.ajax({
      method: "POST",
      url: BASEURL + "dlr_DevSearch",
      data: { DeviceSrNumber: DeviceSrNumber },
      dataType: "json",
      success: function (response) {
        var len = response.length;
        console.log(response);

        $("#devResult").empty();
        for (var i = 0; i < len; i++) {
          var DeviceID = response[i]["DeviceID"];
          var DeviceSrNumber = response[i]["DeviceSrNumber"];
          $("#devResult").append(
            "<li value='" + DeviceID + "'>" + DeviceSrNumber + "</li>"
          );
        }
        $("#devResult li").bind("click", function (e) {
          var TextVal = $(this).text();
          $("#DeviceSr").val(TextVal);
        });
      },
    });
  });
});

function getNames(id, names, tabname, edit, view, editValue) {
  var url = BASEURL + "nameByID";
  $.ajax({
    type: "POST",
    url: url,
    data: { ID: id, Names: names, TabName: tabname },
    dataType: "json",
    success: function (resultData) {
      if (resultData.Status == "1") {
        var des = resultData.data;
        console.log(des);

        $.each(des, function (i) {
          if (edit == des[i][id]) {
            if (editValue == "VehRegNum") {
              $("#VehRegNum").val(des[i][names]);
            }
          }
          if (view !== "") {
            if (view == "VehID") {
              $("#viewVehicle").html(des[i][names]);
            }
            if (view == "InstallDealerID") {
              $("#viewInstallDealer").html(des[i][names]);
            }
            if (view == "DeviceID") {
              $("#viewDevice").html(des[i][names]);
            }
          }
        });
      }
    },
    error: function (error) {
      console.log(error);
    },
  });
}

function tempActReinstate(id) {
  var url = BASEURL + "tempActReinstate";
  $.ajax({
    type: "POST",
    url: url,
    data: { DevInstallationLogID: id },
    dataType: "json",
    success: function (resultData) {
      if (resultData.Status == "1") {
        alertBox(resultData.Status, resultData.Message, tabx);
        $("#DevInstallationTable").DataTable().ajax.reload();
      }
    },
    error: function (error) {
      console.log(error);
    },
  });
}


function VehSearch(searchString) 
{ 

  // Search text
  var text = searchString;
  if(searchString==""){
    $('#VehList').css({"height": "500px"});

  }else{

  
  // Hide all content class element
  $('#devInstallationLogForm').css({"display": "none"});
  $('#VehList').css({"height": "200px"});

  
  // Search and show
  $('#devInstallationLogForm').filter(function() {
    return $(this).text().toLowerCase().indexOf(text.toLowerCase()) != -1;
    }).css({"display": "block"});

  }
 
}


function getDeviceVehList(DevInstallationLogID) {  
    alert("hiiiii");

    $.ajax({
        type: 'POST',
        url: BASEURL+"devInstallationLogList",
        dataType: "json",
        data: {DevInstallationLogID:DevInstallationLogID},
        success: function(resultData) {
            if(resultData.Status == "1"){	
                var  op ="";
                $("#VehList").html("");
                $.each(resultData.data, function(key, value) {
                    let VehID =value["VehID"]; 
                    let DeviceSr =value["DeviceSr"]; 


                    op +='<form id="devInstallationLogForm'+value["VehID"]+'" class="devInstallationLogForm" action="'+BASEURL+'dev_installation_Form.php" method="post"><div class="row pt-3 pb-3 VehList">';

                    
                });
                $('#VehList').append(op);
                var SearchValue = $('#VehSearch').val();
                if(SearchValue !=''){
                  VehSearch(SearchValue);
                }
                
            }
        }
    })
}

