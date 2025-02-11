(win => {
    const {
        "document": doc
        , "location": loc,
    } = win;

    const nodeShow = (node, bool = true) => node.classList[bool ? "remove" : "add"]("hide");
    const lineSeparator = [,,].fill('\n', 0, 2).join('='.repeat(46));

    win.addEventListener(
        "DOMContentLoaded"
        , () => doc.querySelectorAll(".form-send").forEach(
            form => {
                const [status, results,] = ["status", "results",]
                    .map(key => doc.querySelector(form.dataset[key]));

                results.textContent = "";
                ["form-send-status-error", "form-send-status-success"]
                    .forEach(className => status.classList.remove(className));
                [status, results,].forEach(node => nodeShow(node, false));

                form.addEventListener("submit", evt => {
                    evt.preventDefault();

                    fetch(form.getAttribute("action"), {
                            "method": form.getAttribute("method")
                            , "body": new FormData(form),
                        }).then(data => data.json())
                            .then(({"data": data,}) => {
                                status.classList.add("form-send-status-success");

                                results.textContent = data
                                    .map(({"line": line, "count": count,}) => [line, count,].join('=')).join(lineSeparator);
                                [status, results,].forEach(node => nodeShow(node, true));
                            })
                            .catch(error => {
                                status.classList.add("form-send-status-error");

                                console.log(error);
                            });
                    });
            }
        )
    );
})(window);