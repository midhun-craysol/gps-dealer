function loadDataTable (tableID ,fields,ajaxUrl,notSortIndex= [-1]){
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
			'url':BASEURL+ajaxUrl
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

function loadDataTableWithPstruct(tableID ,fields,ajaxUrl,notSortIndex= [-1],projectStructID){
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
            'data':{ "projectStructID":projectStructID}
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

