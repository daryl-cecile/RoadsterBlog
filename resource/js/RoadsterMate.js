/**
 * RoadsterMate: Javascript companion to RoadsterBlog
 *
 * Author: darylcecile <darylcecile@gmail.com>
 * Date: 12/03/2019
 * Time: 06:05
 */
var RoadsterMate;
(function (RoadsterMate) {
    function request(req) {
        if (!req.type)
            req.type = "GET";
        if (!req.onError)
            req.onError = () => { };
        if (!req.onComplete)
            req.onComplete = () => { };
        if (!req.data)
            req.data = [];
        if (!req.headers)
            req.headers = {};
        let headers = {
            "Content-Type": "application/json;charset=UTF-8"
        };
        // Set up our HTTP request
        let xhr = new XMLHttpRequest();
        // Setup our listener to process completed requests
        xhr.onload = function () {
            // Process our return data
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    req.onSuccess(JSON.parse(xhr.response));
                }
                catch (x) {
                    req.onSuccess({
                        Title: "ParseError",
                        Message: "Error parsing response. Check console for details",
                        Data: {
                            "resp": xhr.response
                        },
                        HasErrors: true
                    });
                    console.error(xhr.response);
                }
            }
            else {
                req.onError({
                    Title: "LocalError",
                    Message: "Check console for more info",
                    Data: {},
                    HasErrors: true
                });
                console.error(xhr.response);
            }
            if (req.onComplete)
                req.onComplete();
        };
        Object.assign(req.headers, headers);
        Object.keys(req.headers).forEach(k => {
            xhr.setRequestHeader(k, req.headers[k]);
        });
        xhr.open(req.type, req.url, true);
        xhr.send(JSON.stringify(req.data));
    }
    RoadsterMate.request = request;
})(RoadsterMate || (RoadsterMate = {}));
//# sourceMappingURL=RoadsterMate.js.map