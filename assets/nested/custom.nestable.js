$(document).ready(function()
{
	$('#nestable-menu select[name=keyword]').change(function() {
		var Option = $(this).val();
		location = goUrl + 'frame-reorder?keyword=' + Option + varsExt;
	});

	var updateOutput = function(e)
	{
		var list   = e.length ? e : $(e.target),
			output = list.data('output');
		if (window.JSON) {
			output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
			//$('#nestableMenu').change(function(){
				menu_updatesort(window.JSON.stringify(list.nestable('serialize')));
			//});
		} else {
			output.val('JSON browser support required for this demo.');
		}
	};

	// activate Nestable for list menu
	$('#nestableMenu').nestable({
		group			: 1,
		maxDepth        : maxDepth,
		threshold       : 20
	})
	.on('change', updateOutput);

	// output initial serialised data
	updateOutput($('#nestableMenu').data('output', $('#nestableMenu-output')));

	$('#nestable-menu').on('click', function(e)
	{
		var target = $(e.target),
			action = target.data('action');
		if (action === 'expand-all') {
			$('.dd').nestable('expandAll');
		}
		if (action === 'collapse-all') {
			$('.dd').nestable('collapseAll');
		}
	});

	$('#nestable').nestable();

});