function loadDataTable (pageTable ,fields,ajaxUrl,notSortIndex= [0,-2,-1]){
	columnx =[];
	$.each(fields, function(key, value) { 		
		columnx = [...columnx, {data :value}];
	});

	
// alert(pageTable);
if(pageTable=='CountryTable' || pageTable=='StateTable'){
	var t = $('#'+pageTable).DataTable({
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',	
		'pageLength': 50,	
		'ajax': {
			'url':BASEURL+ajaxUrl
		},
		'columns': columnx ,
		"columnDefs": [
			{ "orderable": false, "targets": notSortIndex }
		  ]
	});
}
else{
	var t = $('#'+pageTable).DataTable({
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		'pageLength': 50,		
		'order' : [1,'desc'],
		'ordering' : true,
		'ajax': {
			'url':BASEURL+ajaxUrl
		},
		'columns': columnx ,
		"columnDefs": [
			{ "orderable": false, "targets": notSortIndex }
		  ]
	});
}
	

	t.on( 'draw.dt', function () {
		var PageInfo = $('#'+pageTable).DataTable().page.info();
		t.column(0, { page: 'current' }).nodes().each( function (cell, i) {
				cell.innerHTML = i + 1 + PageInfo.start;
			} );
		} );
}


function loadDataTableWithFilter(tableID ,fields,ajaxUrl,notSortIndex= [-1],filterObj){
	columnx =[];
	$.each(fields, function(key, value) { 		
		columnx = [...columnx, {data :value}];
	});
	var t = $('#'+tableID).DataTable({
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		"pageLength": 50,
		'ajax': {
			'url':BASEURL+ajaxUrl,
            'data':filterObj
		},
		'columns': columnx ,
		"columnDefs": [
			{ "orderable": false, "targets": notSortIndex }
			]
	});

	t.on( 'draw.dt', function () {
		var PageInfo = $('#'+tableID).DataTable().page.info();
		t.column(0, { page: 'current' }).nodes().each( function (cell, i) {
				cell.innerHTML = i + 1 + PageInfo.start;
			} );
		} );
}
function loadDataTableSOrtable(tableID ,fields,ajaxUrl,notSortIndex= [-1]){
	columnx =[];
	$.each(fields, function(key, value) { 		
		columnx = [...columnx, {data :value}];
	});
	var t = $('#'+tableID).DataTable({
		'processing': true,
		'serverSide': true,
		'serverMethod': 'post',
		"pageLength": 50,
		'ajax': {
			'url':BASEURL+ajaxUrl,
		},
		createdRow: function(row, data, dataIndex, cells) {
			console.log("data",dataIndex);
			$(row).addClass('myRow');
			$(row).attr('idValue',data.idValue);
			$(row).attr('disporder',data.DispOrder);
		  },
		'columns': columnx ,
		"columnDefs": [
			{ "orderable": false, "targets": notSortIndex }
			]
	});

	t.on( 'draw.dt', function () {
		var PageInfo = $('#'+tableID).DataTable().page.info();
		t.column(0, { page: 'current' }).nodes().each( function (cell, i) {
				cell.innerHTML = i + 1 + PageInfo.start;
			} );
		} );
}


