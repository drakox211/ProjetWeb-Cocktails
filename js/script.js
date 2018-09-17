function ingredientLike(val) {
	var mode = document.getElementById("searchMode").checked;
	jQuery.ajax({
		type: "POST",
		url: "libs/extsearch.php",
		data: { val:val,
				mode:mode,
				action:"loadBeginName"},
		cache: false,
		success: function(retour)
		{
			var dropdown = document.getElementById("ingredientDropdown");
			var headNode = document.getElementById("dropdownHeader");
			var ingredientNode;
			var lastChild = headNode;
			
			//Reset dropdown
			while (headNode.nextSibling) {
				dropdown.removeChild(headNode.nextSibling);
			}
			
			//If returned result
			if (retour != "false") {
				var json = JSON.parse(retour);
				
				//Remove diplicates
				var temp = [];
				var flag = false;
				for(let ingredient of json) {
					for (let unique of temp) {
						if (unique["nom"] == ingredient["nom"]) {
							flag = true;
							break;
						}
					}
					if (!flag) temp.push(ingredient);
				}
				
				for(let ingredient of temp) {
					if (isSetIngredient(ingredient["nom"])) continue;
					ingredientNode = document.createElement("a");
					ingredientNode.setAttribute("href", "#");
					ingredientNode.setAttribute("class", "list-group-item list-group-item-action");
					ingredientNode.setAttribute("data-toggle", "modal");
					ingredientNode.setAttribute("data-target", "#ingredientModal");
					ingredientNode.setAttribute("onclick", "updateModal(\"".concat(ingredient["nom"].replace(/'/g, "\\'"), "\")"));
					
					ingredientNode.innerHTML = ingredient["nom"];
					dropdown.insertBefore(ingredientNode, lastChild.nextSibling);
					lastChild = ingredientNode;
				}
			}
			
			//If no ingredients, hide dropdownHeader
			console.log(dropdown.children.length);
			var style = (dropdown.children.length == 1) ? "display: none;": "";
			headNode.setAttribute("style", style);
		}
    });
}

function resetSearchBar() {
	ingredientLike("");
	document.getElementById("ingerdientSearchbar").value = "";
}

function updateModal(nom) {
	document.getElementById("ingredientModalLabel").innerHTML = nom;
	document.getElementById("btnModalAdd").setAttribute("onclick", "addIngredient(\"".concat(nom, "\", 0)"));
	document.getElementById("btnModalAddnt").setAttribute("onclick", "addIngredient(\"".concat(nom, "\", 1)"));
}

function updateModalDiscard(nom, idList) {
	document.getElementById("ingredientModalLabel").innerHTML = nom;
	document.getElementById("btnModalRemove").setAttribute("onclick", "".concat("removeIngredient(\"", nom, "\", ", idList, ")"));
}

function isSetIngredient(nom) {
	var flag = false;
	for (let ingredient of document.getElementById("listContains").children) {
		if (ingredient.firstChild.value == nom) {
			flag = true;
			break;
		}
	}
	if (!flag) {
		for (let ingredient of document.getElementById("listContainsnt").children) {
			if (ingredient.firstChild.value == nom) {
				flag = true;
				break;
			}
		}
	}
	return flag;
}

function updateArgs() {
	var radical = "ing";
	var children = document.getElementById("listContains").children;
	for (i = 0 ; i < children.length ; i++ ) children[i].firstChild.setAttribute("name", "".concat(radical, i));
	children = document.getElementById("listContainsnt").children;
	for (i = 0 ; i < children.length ; i++ ) children[i].firstChild.setAttribute("name", "".concat(radical, "nt", i));
}

function addIngredient(nom, idList) {
	var div1 = document.createElement("div");
	var div2 = document.createElement("div");
	var input1 = document.createElement("input");
	var button1 = document.createElement("button");
	
	div1.setAttribute("class", "input-group mb-3");
	
	div2.setAttribute("class", "input-group-append");
	
	input1.setAttribute("type", "text");
	input1.setAttribute("class", "form-control");
	input1.setAttribute("name", "ing");
	input1.setAttribute("value", nom);
	$(input1).prop('readonly', true);
	
	button1.setAttribute("class", "btn btn-outline-secondary");
	button1.setAttribute("type", "button");
	button1.setAttribute("id", "button-addon2");
	button1.setAttribute("data-toggle", "modal");
	button1.setAttribute("data-target", "#ingredientModalDiscard");
	button1.setAttribute("onclick", "".concat("updateModalDiscard(\"", nom.replace(/'/g, "\\'"), "\", ", idList, ")"));
	button1.innerHTML = "&times;";

	
	div2.appendChild(button1);
	div1.appendChild(input1);
	div1.appendChild(div2);
	
	
	if (idList == 0) document.getElementById("listContains").appendChild(div1);
	else document.getElementById("listContainsnt").appendChild(div1);
	
	updateArgs();
	resetSearchBar();
}

function removeIngredient(nom, idList) {
	var list = (idList == 0) ? "listContains": "listContainsnt";
	for (let node of document.getElementById(list).children) {
		if (node.firstChild.value == nom) {
			document.getElementById(list).removeChild(node);
			break;
		}
	}
	updateArgs();
	resetSearchBar();
}