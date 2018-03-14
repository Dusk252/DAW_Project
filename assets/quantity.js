function updateQuantity(qinput, eventType) {
	if (eventType == "onblur") {
		quantity = qinput.value;
		butId = qinput.getAttribute('id');
		error = document.getElementById("m".concat(butId));
		if (/^(0|[1-9]\d*)$/.test(quantity)) {
			price_el = document.getElementById("p".concat(butId));
			total_el = document.getElementById('total_price');
			values = qinput.getAttribute('alt').split(' ');
			if (quantity!=0) {
				if (quantity <= values[2]) {
					actionUrl = values[0];
					flag = true;
					$.ajax({
					  method: "POST",
					  url: actionUrl,
					  data: {id: butId, quantity: quantity, flag: flag}
					})
					price = parseFloat(price_el.getAttribute('value')) * quantity;
					total = parseFloat(total_el.innerHTML);
					total = total + price - parseFloat(price_el.innerHTML);
					price_el.innerHTML = price.toFixed(2).toString();
					total_el.innerHTML = total.toFixed(2).toString();
					qinput.style.borderColor = "#C5C8C6";
					qinput.style.backgroundColor = "#FFF";
					error.innerHTML = "";
				}
				else {
					qinput.style.borderColor = "#F11E46";
					qinput.style.backgroundColor = "#FEF9E9";
					error.innerHTML = "<br><br>You're trying to order more products than there are in stock.";
				}
			}
			else {
				actionUrl = values[1];
				window.location.href = actionUrl;
			}
		}
		else {
			qinput.style.borderColor = "#F11E46";
			qinput.style.backgroundColor = "#FEF9E9";
			error.innerHTML = "<br><br>Please only enter digits for the quantity.";
		}
	}
}