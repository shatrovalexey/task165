(win => {
	const {
		"document": doc
		, "location": loc,
	} = win;

	win.addEventListener("DOMContentLoaded", () => {
		const nodeFields = doc.querySelectorAll("input[name]");
		const onChangeEvent = nodeSelect => {
			const val = nodeSelect.value;

			nodeFields.forEach(
				nodeField => nodeField.classList[nodeField.getAttribute("name").includes(val) ? "remove" : "add"]("hide")
			);
		};

		doc.querySelectorAll("[name='type_val']")
			.forEach(nodeSelect => {
				nodeSelect.addEventListener("change", () => onChangeEvent(nodeSelect));

				onChangeEvent(nodeSelect);
			});
	});
})(window);