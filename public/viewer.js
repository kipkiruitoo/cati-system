var json_visible = !0,
    json_pnl_size = 0,
    table_visible = !0,
    tree_visible = !0,
    tree_pnl_size = 0,
    xxa_pnl_size = 0;
jQuery(function(a) {
    function e() {
        json_visible
            ? (a("#all_panels")
                  .split()
                  .position(a("#all_panels").width() - xxa_pnl_size - 2),
              table_visible && tree_visible
                  ? a("#xxa")
                        .split()
                        .position(xxa_pnl_size - tree_pnl_size - 2)
                  : !table_visible && tree_visible
                  ? a("#xxa")
                        .split()
                        .position(0)
                  : table_visible && !tree_visible
                  ? a("#xxa")
                        .split()
                        .position(xxa_pnl_size)
                  : table_visible ||
                    tree_visible ||
                    a("#all_panels")
                        .split()
                        .position(a("#all_panels").width()))
            : (a("#all_panels")
                  .split()
                  .position(0),
              table_visible && tree_visible
                  ? a("#xxa")
                        .split()
                        .position(xxa_pnl_size - tree_pnl_size - 2)
                  : !table_visible && tree_visible
                  ? a("#xxa")
                        .split()
                        .position(0)
                  : table_visible &&
                    !tree_visible &&
                    a("#xxa")
                        .split()
                        .position(a("#all_panels").width() - 2));
    }
    a("#all_panels").split({
        orientation: "vertical",
        limit: 0,
        position: "33%"
    });
    a("#xxa").split({ orientation: "vertical", limit: 0, position: "50%" });
    tree_pnl_size = a("#tree_pnl").width();
    json_pnl_size = a("#json_pnl").width();
    xxa_pnl_size = a("#xxa").width();
    a("#all_panels").split().settings.onDrag = function() {
        json_visible
            ? ((json_pnl_size = a("#json_pnl").width()),
              (xxa_pnl_size = a("#xxa").width()),
              table_visible && tree_visible
                  ? a("#xxa")
                        .split()
                        .position(xxa_pnl_size - tree_pnl_size - 2)
                  : table_visible && !tree_visible
                  ? a("#xxa")
                        .split()
                        .position(xxa_pnl_size - 2)
                  : !table_visible &&
                    tree_visible &&
                    a("#xxa")
                        .split()
                        .position(0))
            : a("#all_panels")
                  .split()
                  .position(0);
    };
    a("#xxa").split().settings.onDrag = function() {
        !table_visible && tree_visible
            ? a("#xxa")
                  .split()
                  .position(0)
            : (tree_pnl_size = a("#tree_pnl").width());
    };
    a("#jsonViewMenu").click(function() {
        if (table_visible || tree_visible)
            a("#jsonLi").toggleClass("active "),
                (json_visible = !json_visible),
                e();
    });
    a("#tableViewMenu").click(function() {
        if (json_visible || tree_visible)
            a("#tableLi").toggleClass("active "),
                (table_visible = !table_visible),
                e();
    });
    a("#treeViewMenu").click(function() {
        if (json_visible || table_visible)
            a("#treeLi").toggleClass("active "),
                (tree_visible = !tree_visible),
                e();
    });
    a("#load_json_btn").click(function() {
        processJson();
    });
    a("#aboutLnk").click(function() {
        a("#leaveMsg").val("");
        a("#msgConfirmation").hide();
        a("#msgForm").show();
        a("#aboutModal").modal("show");
    });
    a("#sendMsgBtn").click(function() {
        a("#msgForm").hide();
        a("#msgConfirmation").show();
        sendMsg();
    });
    a("#load_url_btn").click(function() {
        a("#inputURLModal").modal("show");
    });
    a("#exec_loadBtn").click(function() {
        loadfromURL(a("#urlInput").val());
    });
});
function sendMsg() {
    $.ajax({
        type: "GET",
        url: "http://json2table-env-ayji8pibkt.elasticbeanstalk.com/save_msg",
        data: { callback: "call", msg: $("#leaveMsg").val() },
        contentType: "application/json",
        dataType: "jsonp",
        success: function(a) {},
        error: function(a) {}
    });
}
var g;
function loadfromURL(a) {
    $("#json_vl").val("Loading...");
    $("#inner_tree").html("");
    $("#inner_tbl").html("");
    "http" != a.substr(0, 4) && (a = "http://" + a);
    $.ajax({
        type: "GET",
        url: "http://json2table-env-ayji8pibkt.elasticbeanstalk.com/getjson",
        data: { callback: "call", url: encodeURIComponent(a) },
        contentType: "application/json",
        dataType: "jsonp",
        success: function(a) {
            $("#json_vl").val(JSON.stringify(a, void 0, 2));
            processJson();
        },
        error: function(e) {
            $("#json_vl").val("");
            $("#error_msg").text("Not a valid JSON from " + a);
            $("#errorModal").modal("show");
            return {};
        }
    });
}
function call(a) {
    $("#json_vl").val(JSON.stringify(a, void 0, 2));
    processJson();
}
function processJson(json) {
    $("#inner_tbl").html(buildTable(json));
    showTree();
}
function getJsonVar() {
    try {
        var a = $.parseJSON($("#json_vl").val());
        $("#json_vl").val(JSON.stringify(a, void 0, 2));
        return a;
    } catch (e) {
        return (
            $("#error_msg").text(e.message), $("#errorModal").modal("show"), {}
        );
    }
}
function showTree() {
    var a = document.createElement("ol"),
        e = document.createElement("li"),
        d =
            "_" +
            Math.random()
                .toString(36)
                .substr(2, 9);
    e.innerHTML =
        "<label for='" +
        d +
        "' class='lbl_obj'>&nbsp;</label> <input type='checkbox' checked id='" +
        d +
        "' />";
    d = document.createElement("ol");
    e.appendChild(d);
    a.appendChild(e);
    buildTree(getJsonVar(), 0, d);
    $("#inner_tree").html(a);
}
function buildTable(a) {
    var e = document.createElement("table"),
        d,
        b;
    if (isArray(a)) return buildArray(a);
    for (var c in a)
        "object" != typeof a[c] || isArray(a[c])
            ? "object" == typeof a[c] && isArray(a[c])
                ? ((d = e.insertRow(-1)),
                  (b = d.insertCell(-1)),
                  (b.colSpan = 2),
                  (b.innerHTML =
                      '<div class="td_head">' +
                      encodeText(c) +
                      '</div><table style="width:100%">' +
                      $(buildArray(a[c]), !1).html() +
                      "</table>"))
                : ((d = e.insertRow(-1)),
                  (b = d.insertCell(-1)),
                  (b.innerHTML =
                      "<div class='td_head'>" + encodeText(c) + "</div>"),
                  (d = d.insertCell(-1)),
                  (d.innerHTML =
                      "<div class='td_row_even'>" +
                      encodeText(a[c]) +
                      "</div>"))
            : ((d = e.insertRow(-1)),
              (b = d.insertCell(-1)),
              (b.colSpan = 2),
              (b.innerHTML =
                  '<div class="td_head">' +
                  encodeText(c) +
                  '</div><table style="width:100%">' +
                  $(buildTable(a[c]), !1).html() +
                  "</table>"));
    return e;
}
function buildArray(a) {
    var e = document.createElement("table"),
        d,
        b,
        c = !1,
        p = !1,
        m = {},
        h = -1,
        n = 0,
        l;
    l = "";
    if (0 == a.length) return "<div></div>";
    d = e.insertRow(-1);
    for (var f = 0; f < a.length; f++)
        if ("object" != typeof a[f] || isArray(a[f]))
            "object" == typeof a[f] && isArray(a[f])
                ? ((b = d.insertCell(h)),
                  (b.colSpan = 2),
                  (b.innerHTML =
                      '<div class="td_head"></div><table style="width:100%">' +
                      $(buildArray(a[f]), !1).html() +
                      "</table>"),
                  (c = !0))
                : p ||
                  ((h += 1),
                  (p = !0),
                  (b = d.insertCell(h)),
                  (m.empty = h),
                  (b.innerHTML = "<div class='td_head'>&nbsp;</div>"));
        else
            for (var k in a[f])
                (l = "-" + k),
                    l in m ||
                        ((c = !0),
                        (h += 1),
                        (b = d.insertCell(h)),
                        (m[l] = h),
                        (b.innerHTML =
                            "<div class='td_head'>" +
                            encodeText(k) +
                            "</div>"));
    c || e.deleteRow(0);
    n = h + 1;
    for (f = 0; f < a.length; f++)
        if (
            ((d = e.insertRow(-1)),
            (td_class = isEven(f) ? "td_row_even" : "td_row_odd"),
            "object" != typeof a[f] || isArray(a[f]))
        )
            if ("object" == typeof a[f] && isArray(a[f]))
                for (h = m.empty, c = 0; c < n; c++)
                    (b = d.insertCell(c)),
                        (b.className = td_class),
                        (l =
                            c == h
                                ? '<table style="width:100%">' +
                                  $(buildArray(a[f]), !1).html() +
                                  "</table>"
                                : " "),
                        (b.innerHTML =
                            "<div class='" +
                            td_class +
                            "'>" +
                            encodeText(l) +
                            "</div>");
            else
                for (h = m.empty, c = 0; c < n; c++)
                    (b = d.insertCell(c)),
                        (l = c == h ? a[f] : " "),
                        (b.className = td_class),
                        (b.innerHTML =
                            "<div class='" +
                            td_class +
                            "'>" +
                            encodeText(l) +
                            "</div>");
        else {
            for (c = 0; c < n; c++)
                (b = d.insertCell(c)),
                    (b.className = td_class),
                    (b.innerHTML =
                        "<div class='" + td_class + "'>&nbsp;</div>");
            for (k in a[f])
                (c = a[f]),
                    (l = "-" + k),
                    (h = m[l]),
                    (b = d.cells[h]),
                    (b.className = td_class),
                    "object" != typeof c[k] || isArray(c[k])
                        ? "object" == typeof c[k] && isArray(c[k])
                            ? (b.innerHTML =
                                  '<table style="width:100%">' +
                                  $(buildArray(c[k]), !1).html() +
                                  "</table>")
                            : (b.innerHTML =
                                  "<div class='" +
                                  td_class +
                                  "'>" +
                                  encodeText(c[k]) +
                                  "</div>")
                        : (b.innerHTML =
                              '<table style="width:100%">' +
                              $(buildTable(c[k]), !1).html() +
                              "</table>");
        }
    return e;
}
function encodeText(a) {
    return $("<div />")
        .text(a)
        .html();
}
function isArray(a) {
    return "[object Array]" === Object.prototype.toString.call(a);
}
function isEven(a) {
    return 0 == a % 2;
}
function buildTree(a, e, d) {
    e += 1;
    if ("undefined" === typeof a) log("undef!!", e);
    else
        for (var b in a)
            if ("object" == typeof a[b]) {
                var c = addTree(b, d, isArray(a[b]));
                buildTree(a[b], e, c);
            } else addLeaf(b, a, d);
}
function addTree(a, e, d) {
    var b = "lbl_obj";
    d && (b = "lbl_array");
    var c =
        "_" +
        Math.random()
            .toString(36)
            .substr(2, 9);
    d = document.createElement("li");
    d.innerHTML =
        "<label for='" +
        c +
        "' class='" +
        b +
        "'>" +
        encodeText(a) +
        "</label> <input type='checkbox' checked id='" +
        c +
        "' />";
    a = document.createElement("ol");
    d.appendChild(a);
    null != e && e.appendChild(d);
    return a;
}
function addLeaf(a, e, d) {
    var b = "";
    isArray(e) || (b = a + ":");
    b += e[a];
    Math.random()
        .toString(36)
        .substr(2, 9);
    a = document.createElement("li");
    a.className = "file";
    a.innerHTML = "<a>" + encodeText(b) + "</a>";
    d.appendChild(a);
}
function log(a, e, d) {
    console.log(a);
}

/* FileSaver.js
 *  A saveAs() FileSaver implementation.
 *  2014-05-27
 *
 *  By Eli Grey, http://eligrey.com
 *  License: X11/MIT
 *    See https://github.com/eligrey/FileSaver.js/blob/master/LICENSE.md
 */

/*global self */
/*jslint bitwise: true, indent: 4, laxbreak: true, laxcomma: true, smarttabs: true, plusplus: true */

/*! @source http://purl.eligrey.com/github/FileSaver.js/blob/master/FileSaver.js */

var saveAs =
    saveAs ||
    // IE 10+ (native saveAs)
    (typeof navigator !== "undefined" &&
        navigator.msSaveOrOpenBlob &&
        navigator.msSaveOrOpenBlob.bind(navigator)) ||
    // Everyone else
    (function(view) {
        "use strict";
        // IE <10 is explicitly unsupported
        if (
            typeof navigator !== "undefined" &&
            /MSIE [1-9]\./.test(navigator.userAgent)
        ) {
            return;
        }
        var doc = view.document,
            // only get URL when necessary in case Blob.js hasn't overridden it yet
            get_URL = function() {
                return view.URL || view.webkitURL || view;
            },
            save_link = doc.createElementNS(
                "http://www.w3.org/1999/xhtml",
                "a"
            ),
            can_use_save_link = !view.externalHost && "download" in save_link,
            click = function(node) {
                var event = doc.createEvent("MouseEvents");
                event.initMouseEvent(
                    "click",
                    true,
                    false,
                    view,
                    0,
                    0,
                    0,
                    0,
                    0,
                    false,
                    false,
                    false,
                    false,
                    0,
                    null
                );
                node.dispatchEvent(event);
            },
            webkit_req_fs = view.webkitRequestFileSystem,
            req_fs =
                view.requestFileSystem ||
                webkit_req_fs ||
                view.mozRequestFileSystem,
            throw_outside = function(ex) {
                (view.setImmediate || view.setTimeout)(function() {
                    throw ex;
                }, 0);
            },
            force_saveable_type = "application/octet-stream",
            fs_min_size = 0,
            deletion_queue = [],
            process_deletion_queue = function() {
                var i = deletion_queue.length;
                while (i--) {
                    var file = deletion_queue[i];
                    if (typeof file === "string") {
                        // file is an object URL
                        get_URL().revokeObjectURL(file);
                    } else {
                        // file is a File
                        file.remove();
                    }
                }
                deletion_queue.length = 0; // clear queue
            },
            dispatch = function(filesaver, event_types, event) {
                event_types = [].concat(event_types);
                var i = event_types.length;
                while (i--) {
                    var listener = filesaver["on" + event_types[i]];
                    if (typeof listener === "function") {
                        try {
                            listener.call(filesaver, event || filesaver);
                        } catch (ex) {
                            throw_outside(ex);
                        }
                    }
                }
            },
            FileSaver = function(blob, name) {
                // First try a.download, then web filesystem, then object URLs
                var filesaver = this,
                    type = blob.type,
                    blob_changed = false,
                    object_url,
                    target_view,
                    get_object_url = function() {
                        var object_url = get_URL().createObjectURL(blob);
                        deletion_queue.push(object_url);
                        return object_url;
                    },
                    dispatch_all = function() {
                        dispatch(
                            filesaver,
                            "writestart progress write writeend".split(" ")
                        );
                    },
                    // on any filesys errors revert to saving with object URLs
                    fs_error = function() {
                        // don't create more object URLs than needed
                        if (blob_changed || !object_url) {
                            object_url = get_object_url(blob);
                        }
                        if (target_view) {
                            target_view.location.href = object_url;
                        } else {
                            window.open(object_url, "_blank");
                        }
                        filesaver.readyState = filesaver.DONE;
                        dispatch_all();
                    },
                    abortable = function(func) {
                        return function() {
                            if (filesaver.readyState !== filesaver.DONE) {
                                return func.apply(this, arguments);
                            }
                        };
                    },
                    create_if_not_found = { create: true, exclusive: false },
                    slice;
                filesaver.readyState = filesaver.INIT;
                if (!name) {
                    name = "download";
                }
                if (can_use_save_link) {
                    object_url = get_object_url(blob);
                    save_link.href = object_url;
                    save_link.download = name;
                    click(save_link);
                    filesaver.readyState = filesaver.DONE;
                    dispatch_all();
                    return;
                }
                // Object and web filesystem URLs have a problem saving in Google Chrome when
                // viewed in a tab, so I force save with application/octet-stream
                // http://code.google.com/p/chromium/issues/detail?id=91158
                if (view.chrome && type && type !== force_saveable_type) {
                    slice = blob.slice || blob.webkitSlice;
                    blob = slice.call(blob, 0, blob.size, force_saveable_type);
                    blob_changed = true;
                }
                // Since I can't be sure that the guessed media type will trigger a download
                // in WebKit, I append .download to the filename.
                // https://bugs.webkit.org/show_bug.cgi?id=65440
                if (webkit_req_fs && name !== "download") {
                    name += ".download";
                }
                if (type === force_saveable_type || webkit_req_fs) {
                    target_view = view;
                }
                if (!req_fs) {
                    fs_error();
                    return;
                }
                fs_min_size += blob.size;
                req_fs(
                    view.TEMPORARY,
                    fs_min_size,
                    abortable(function(fs) {
                        fs.root.getDirectory(
                            "saved",
                            create_if_not_found,
                            abortable(function(dir) {
                                var save = function() {
                                    dir.getFile(
                                        name,
                                        create_if_not_found,
                                        abortable(function(file) {
                                            file.createWriter(
                                                abortable(function(writer) {
                                                    writer.onwriteend = function(
                                                        event
                                                    ) {
                                                        target_view.location.href = file.toURL();
                                                        deletion_queue.push(
                                                            file
                                                        );
                                                        filesaver.readyState =
                                                            filesaver.DONE;
                                                        dispatch(
                                                            filesaver,
                                                            "writeend",
                                                            event
                                                        );
                                                    };
                                                    writer.onerror = function() {
                                                        var error =
                                                            writer.error;
                                                        if (
                                                            error.code !==
                                                            error.ABORT_ERR
                                                        ) {
                                                            fs_error();
                                                        }
                                                    };
                                                    "writestart progress write abort"
                                                        .split(" ")
                                                        .forEach(function(
                                                            event
                                                        ) {
                                                            writer[
                                                                "on" + event
                                                            ] =
                                                                filesaver[
                                                                    "on" + event
                                                                ];
                                                        });
                                                    writer.write(blob);
                                                    filesaver.abort = function() {
                                                        writer.abort();
                                                        filesaver.readyState =
                                                            filesaver.DONE;
                                                    };
                                                    filesaver.readyState =
                                                        filesaver.WRITING;
                                                }),
                                                fs_error
                                            );
                                        }),
                                        fs_error
                                    );
                                };
                                dir.getFile(
                                    name,
                                    { create: false },
                                    abortable(function(file) {
                                        // delete file if it already exists
                                        file.remove();
                                        save();
                                    }),
                                    abortable(function(ex) {
                                        if (ex.code === ex.NOT_FOUND_ERR) {
                                            save();
                                        } else {
                                            fs_error();
                                        }
                                    })
                                );
                            }),
                            fs_error
                        );
                    }),
                    fs_error
                );
            },
            FS_proto = FileSaver.prototype,
            saveAs = function(blob, name) {
                return new FileSaver(blob, name);
            };
        FS_proto.abort = function() {
            var filesaver = this;
            filesaver.readyState = filesaver.DONE;
            dispatch(filesaver, "abort");
        };
        FS_proto.readyState = FS_proto.INIT = 0;
        FS_proto.WRITING = 1;
        FS_proto.DONE = 2;

        FS_proto.error = FS_proto.onwritestart = FS_proto.onprogress = FS_proto.onwrite = FS_proto.onabort = FS_proto.onerror = FS_proto.onwriteend = null;

        view.addEventListener("unload", process_deletion_queue, false);
        saveAs.unload = function() {
            process_deletion_queue();
            view.removeEventListener("unload", process_deletion_queue, false);
        };
        return saveAs;
    })(
        (typeof self !== "undefined" && self) ||
            (typeof window !== "undefined" && window) ||
            this.content
    );
// `self` is undefined in Firefox for Android content script context
// while `this` is nsIContentFrameMessageManager
// with an attribute `content` that corresponds to the window

if (typeof module !== "undefined" && module !== null) {
    module.exports = saveAs;
} else if (
    typeof define !== "undefined" &&
    define !== null &&
    define.amd != null
) {
    define([], function() {
        return saveAs;
    });
}
