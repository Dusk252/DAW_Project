window.onload = function()
      {
         var triggers = document.getElementsByClassName("form-button");

         for(var i = 0; i < triggers.length; i++)
         {
            (function()
            {
				var trigger = triggers[i];
				trigger.onclick = function(e)
				{
					if (trigger.getAttribute('class') != 'product-added') {
						e.preventDefault();
					}
					butId = trigger.getAttribute('id');
					actionUrl = trigger.getAttribute('href');
					actionUrl = actionUrl.substr(0, actionUrl.lastIndexOf("/"));
					$.ajax({
					  method: "POST",
					  url: actionUrl,
					  data: {id: butId}
					})
					trigger.setAttribute('class', 'product-added');
					trigger.setAttribute('href', trigger.getAttribute('alt'));
					if (actionUrl.includes("cart")) {
						trigger.innerHTML = 'View Cart';
					}
					else if (actionUrl.includes("user")) {
						trigger.innerHTML = 'View Wishlist';
					}
				}
            })();
         }
      }