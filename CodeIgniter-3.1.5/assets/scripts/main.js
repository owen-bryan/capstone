$(document).ready(function(){
	$("#show_more").click(function(){
		$("#advanced_options").toggleClass("hidden");
	});

	$("#province").change(function()
	{
		if($("#province").val() != "all")
		{
			$("#city").prop('disabled', false);
			$.get(
			"https://csunix.mohawkcollege.ca/~000340128/private/capstone-project/CodeIgniter-3.1.5/index.php?c=search&m=get_cities_json",
			{province : $("#province").val()},
			function(data)
			{
				var cities = $("#city");
				cities.empty();
				cities.append('<option value="all">City</option>');
				for  (var i = 0; i < data.length; i++)
				{
					var row = data[i];
					cities.append('<option value="' + row.city +'">' + row.city + "</option>");
					console.log(row);
				}
			}
			,
			"json");
		}
		else
		{
			$("#city").prop('disabled', true);
		}
		
	});

	
	$("#manufacturer").change(function()
	{
		if($("#manufacturer").val() != "all")
		{
			$("#brand").prop('disabled', false);
			$.get(
			"https://csunix.mohawkcollege.ca/~000340128/private/capstone-project/CodeIgniter-3.1.5/index.php?c=search&m=get_brands_json",
			{manufacturer : $("#manufacturer").val()},
			function(data)
			{
				var brands = $("#brand");
				brands.empty();
				brands.append('<option value="all">Brand</option>');
				for  (var i = 0; i < data.length; i++)
				{
					var row = data[i];
					brands.append('<option value="' + row.brand_id +'">' + row.brand_name + "</option>");
					console.log(row);
				}
			}
			,
			"json");
		}
		else
		{
			$("#brand").prop('disabled', true);
		}
		
	});
});