/* NicEdit - Micro Inline WYSIWYG
 * Copyright 2007-2008 Brian Kirchoff
 *
 * NicEdit is distributed under the terms of the MIT license
 * For more information visit http://nicedit.com/
 * Do not remove this copyright message
 */
var bkExtend = function() {
    var A = arguments;
    if (A.length == 1) {
        A = [this, A[0]]
    }
    for (var B in A[1]) {
        A[0][B] = A[1][B]
    }
    return A[0]
};

function bkClass() {}
bkClass.prototype.construct = function() {};
bkClass.extend = function(C) {
    var A = function() {
        if (arguments[0] !== bkClass) {
            return this.construct.apply(this, arguments)
        }
    };
    var B = new this(bkClass);
    bkExtend(B, C);
    A.prototype = B;
    A.extend = this.extend;
    return A
};
var bkElement = bkClass.extend({
    construct: function(B, A) {
        if (typeof(B) == "string") {
            B = (A || document).createElement(B)
        }
        B = $BK(B);
        return B
    },
    appendTo: function(A) {
        A.appendChild(this);
        return this
    },
    appendBefore: function(A) {
        A.parentNode.insertBefore(this, A);
        return this
    },
    addEvent: function(B, A) {
        bkLib.addEvent(this, B, A);
        return this
    },
    setContent: function(A) {
        this.innerHTML = A;
        return this
    },
    pos: function() {
        var C = curtop = 0;
        var B = obj = this;
        if (obj.offsetParent) {
            do {
                C += obj.offsetLeft;
                curtop += obj.offsetTop
            } while (obj = obj.offsetParent)
        }
        var A = (!window.opera) ? parseInt(this.getStyle("border-width") || this.style.border) || 0 : 0;
        return [C + A, curtop + A + this.offsetHeight]
    },
    noSelect: function() {
        bkLib.noSelect(this);
        return this
    },
    parentTag: function(A) {
        var B = this;
        do {
            if (B && B.nodeName && B.nodeName.toUpperCase() == A) {
                return B
            }
            B = B.parentNode
        } while (B);
        return false
    },
    hasClass: function(A) {
        return this.className.match(new RegExp("(\\s|^)nicEdit-" + A + "(\\s|$)"))
    },
    addClass: function(A) {
        if (!this.hasClass(A)) {
            this.className += " nicEdit-" + A
        }
        return this
    },
    removeClass: function(A) {
        if (this.hasClass(A)) {
            this.className = this.className.replace(new RegExp("(\\s|^)nicEdit-" + A + "(\\s|$)"), " ")
        }
        return this
    },
    setStyle: function(A) {
        var B = this.style;
        for (var C in A) {
            switch (C) {
                case "float":
                    B.cssFloat = B.styleFloat = A[C];
                    break;
                case "opacity":
                    B.opacity = A[C];
                    B.filter = "alpha(opacity=" + Math.round(A[C] * 100) + ")";
                    break;
                case "className":
                    this.className = A[C];
                    break;
                default:
                    B[C] = A[C]
            }
        }
        return this
    },
    getStyle: function(A, C) {
        var B = (!C) ? document.defaultView : C;
        if (this.nodeType == 1) {
            return (B && B.getComputedStyle) ? B.getComputedStyle(this, null).getPropertyValue(A) : this.currentStyle[bkLib.camelize(A)]
        }
    },
    remove: function() {
        this.parentNode.removeChild(this);
        return this
    },
    setAttributes: function(A) {
        for (var B in A) {
            this[B] = A[B]
        }
        return this
    }
});
var bkLib = {
    isMSIE: (navigator.appVersion.indexOf("MSIE") != -1),
    addEvent: function(C, B, A) {
        (C.addEventListener) ? C.addEventListener(B, A, false): C.attachEvent("on" + B, A)
    },
    toArray: function(C) {
        var B = C.length,
            A = new Array(B);
        while (B--) {
            A[B] = C[B]
        }
        return A
    },
    noSelect: function(B) {
        if (B.setAttribute && B.nodeName.toLowerCase() != "input" && B.nodeName.toLowerCase() != "textarea") {
            B.setAttribute("unselectable", "on")
        }
        for (var A = 0; A < B.childNodes.length; A++) {
            bkLib.noSelect(B.childNodes[A])
        }
    },
    camelize: function(A) {
        return A.replace(/\-(.)/g, function(B, C) {
            return C.toUpperCase()
        })
    },
    inArray: function(A, B) {
        return (bkLib.search(A, B) != null)
    },
    search: function(A, C) {
        for (var B = 0; B < A.length; B++) {
            if (A[B] == C) {
                return B
            }
        }
        return null
    },
    cancelEvent: function(A) {
        A = A || window.event;
        if (A.preventDefault && A.stopPropagation) {
            A.preventDefault();
            A.stopPropagation()
        }
        return false
    },
    domLoad: [],
    domLoaded: function() {
        if (arguments.callee.done) {
            return
        }
        arguments.callee.done = true;
        for (i = 0; i < bkLib.domLoad.length; i++) {
            bkLib.domLoad[i]()
        }
    },
    onDomLoaded: function(A) {
        this.domLoad.push(A);
        if (document.addEventListener) {
            document.addEventListener("DOMContentLoaded", bkLib.domLoaded, null)
        } else {
            if (bkLib.isMSIE) {
                document.write("<style>.nicEdit-main p { margin: 0; }</style><script id=__ie_onload defer " + ((location.protocol == "https:") ? "src='javascript:void(0)'" : "src=//0") + "><\/script>");
                $BK("__ie_onload").onreadystatechange = function() {
                    if (this.readyState == "complete") {
                        bkLib.domLoaded()
                    }
                }
            }
        }
        window.onload = bkLib.domLoaded
    }
};

function $BK(A) {
    if (typeof(A) == "string") {
        A = document.getElementById(A)
    }
    return (A && !A.appendTo) ? bkExtend(A, bkElement.prototype) : A
}
var bkEvent = {
    addEvent: function(A, B) {
        if (B) {
            this.eventList = this.eventList || {};
            this.eventList[A] = this.eventList[A] || [];
            this.eventList[A].push(B)
        }
        return this
    },
    fireEvent: function() {
        var A = bkLib.toArray(arguments),
            C = A.shift();
        if (this.eventList && this.eventList[C]) {
            for (var B = 0; B < this.eventList[C].length; B++) {
                this.eventList[C][B].apply(this, A)
            }
        }
    }
};

function __(A) {
    return A
}
Function.prototype.closure = function() {
    var A = this,
        B = bkLib.toArray(arguments),
        C = B.shift();
    return function() {
        if (typeof(bkLib) != "undefined") {
            return A.apply(C, B.concat(bkLib.toArray(arguments)))
        }
    }
};
Function.prototype.closureListener = function() {
    var A = this,
        C = bkLib.toArray(arguments),
        B = C.shift();
    return function(E) {
        E = E || window.event;
        if (E.target) {
            var D = E.target
        } else {
            var D = E.srcElement
        }
        return A.apply(B, [E, D].concat(C))
    }
};



var nicEditorConfig = bkClass.extend({
    buttons: {
        'bold': {
            name: __('Negrito'),
            command: 'Bold',
            tags: ['B', 'STRONG'],
            css: {
                'font-weight': 'bold'
            },
            key: 'b'
        },
        'italic': {
            name: __('Itálico'),
            command: 'Italic',
            tags: ['EM', 'I'],
            css: {
                'font-style': 'italic'
            },
            key: 'i'
        },
        'underline': {
            name: __('Sublinhado'),
            command: 'Underline',
            tags: ['U'],
            css: {
                'text-decoration': 'underline'
            },
            key: 'u'
        },
        'left': {
            name: __('Alinhar à esquerda'),
            command: 'justifyleft',
            noActive: true
        },
        'center': {
            name: __('Centralizar'),
            command: 'justifycenter',
            noActive: true
        },
        'right': {
            name: __('Alinhar à direita'),
            command: 'justifyright',
            noActive: true
        },
        'justify': {
            name: __('Justificar'),
            command: 'justifyfull',
            noActive: true
        },
        'ol': {
            name: __('Inserir lista numérica'),
            command: 'insertorderedlist',
            tags: ['OL']
        },
        'ul': {
            name: __('Inserir lista'),
            command: 'insertunorderedlist',
            tags: ['UL']
        },
        'subscript': {
            name: __('Subscrito'),
            command: 'subscript',
            tags: ['SUB']
        },
        'superscript': {
            name: __('Sobrescrito'),
            command: 'superscript',
            tags: ['SUP']
        },
        'strikethrough': {
            name: __('Tachado'),
            command: 'strikeThrough',
            css: {
                'text-decoration': 'line-through'
            }
        },
        'removeformat': {
            name: __('Remover formatação'),
            command: 'removeformat',
            noActive: true
        },
        'indent': {
            name: __('Adicionar recuo'),
            command: 'indent',
            noActive: true
        },
        'outdent': {
            name: __('Remover recuo'),
            command: 'outdent',
            noActive: true
        },
        'hr': {
            name: __('Inserir linha horizontal'),
            command: 'insertHorizontalRule',
            noActive: true
        }
    },
    iconsPath: '../images/nicEditorIcons.gif',
    buttonList: ['save', 'bold', 'italic', 'underline', 'left', 'center', 'right', 'justify', 'ol', 'ul', 'fontSize', 'fontFamily', 'fontFormat', 'indent', 'outdent', 'image', 'upload', 'link', 'unlink', 'forecolor', 'bgcolor'],
    iconList: {
        "bgcolor": 1,
        "forecolor": 2,
        "bold": 3,
        "center": 4,
        "hr": 5,
        "indent": 6,
        "italic": 7,
        "justify": 8,
        "left": 9,
        "ol": 10,
        "outdent": 11,
        "removeformat": 12,
        "right": 13,
        "save": 24,
        "strikethrough": 15,
        "subscript": 16,
        "superscript": 17,
        "ul": 18,
        "underline": 19,
        "image": 20,
        "link": 21,
        "unlink": 22,
        "close": 23,
        "arrow": 25
    }

});;
var nicEditors = {
    nicPlugins: [],
    editors: [],
    registerPlugin: function(B, A) {
        this.nicPlugins.push({
            p: B,
            o: A
        })
    },
    allTextAreas: function(C) {
        var A = document.getElementsByTagName("textarea");
        for (var B = 0; B < A.length; B++) {
            nicEditors.editors.push(new nicEditor(C).panelInstance(A[B]))
        }
        return nicEditors.editors
    },
    findEditor: function(C) {
        var B = nicEditors.editors;
        for (var A = 0; A < B.length; A++) {
            if (B[A].instanceById(C)) {
                return B[A].instanceById(C)
            }
        }
    }
};
var nicEditor = bkClass.extend({
    construct: function(C) {
        this.options = new nicEditorConfig();
        bkExtend(this.options, C);
        this.nicInstances = new Array();
        this.loadedPlugins = new Array();
        var A = nicEditors.nicPlugins;
        for (var B = 0; B < A.length; B++) {
            this.loadedPlugins.push(new A[B].p(this, A[B].o))
        }
        nicEditors.editors.push(this);
        bkLib.addEvent(document.body, "mousedown", this.selectCheck.closureListener(this))
    },
    panelInstance: function(B, C) {
        B = this.checkReplace($BK(B));
        var A = new bkElement("DIV").setStyle({
            width: (parseInt(B.getStyle("width")) || B.clientWidth) + "px"
        }).appendBefore(B);
        this.setPanel(A);
        return this.addInstance(B, C)
    },
    checkReplace: function(B) {
        var A = nicEditors.findEditor(B);
        if (A) {
            A.removeInstance(B);
            A.removePanel()
        }
        return B
    },
    addInstance: function(B, C) {
        B = this.checkReplace($BK(B));
        if (B.contentEditable || !!window.opera) {
            var A = new nicEditorInstance(B, C, this)
        } else {
            var A = new nicEditorIFrameInstance(B, C, this)
        }
        this.nicInstances.push(A);
        return this
    },
    removeInstance: function(C) {
        C = $BK(C);
        var B = this.nicInstances;
        for (var A = 0; A < B.length; A++) {
            if (B[A].e == C) {
                B[A].remove();
                this.nicInstances.splice(A, 1)
            }
        }
    },
    removePanel: function(A) {
        if (this.nicPanel) {
            this.nicPanel.remove();
            this.nicPanel = null
        }
    },
    instanceById: function(C) {
        C = $BK(C);
        var B = this.nicInstances;
        for (var A = 0; A < B.length; A++) {
            if (B[A].e == C) {
                return B[A]
            }
        }
    },
    setPanel: function(A) {
        this.nicPanel = new nicEditorPanel($BK(A), this.options, this);
        this.fireEvent("panel", this.nicPanel);
        return this
    },
    nicCommand: function(B, A) {
        if (this.selectedInstance) {
            this.selectedInstance.nicCommand(B, A)
        }
    },
    getIcon: function(D, A) {
        var C = this.options.iconList[D];
        var B = (A.iconFiles) ? A.iconFiles[D] : "";
        return {
            backgroundImage: "url('" + ((C) ? this.options.iconsPath : B) + "')",
            backgroundPosition: ((C) ? ((C - 1) * -18) : 0) + "px 0px"
        }
    },
    selectCheck: function(C, A) {
        var B = false;
        do {
            if (A.className && A.className.indexOf("nicEdit") != -1) {
                return false
            }
        } while (A = A.parentNode);
        this.fireEvent("blur", this.selectedInstance, A);
        this.lastSelectedInstance = this.selectedInstance;
        this.selectedInstance = null;
        return false
    }
});
nicEditor = nicEditor.extend(bkEvent);
/*var nicEditorInstance = bkClass.extend({
    isSelected: false,
    construct: function(G, D, C) {
        this.ne = C;
        this.elm = this.e = G;
        this.options = D || {};
        newX = parseInt(G.getStyle("width")) || G.clientWidth;
        newY = parseInt(G.getStyle("height")) || G.clientHeight;
        this.initialHeight = newY - 8;
        var H = (G.nodeName.toLowerCase() == "textarea");
        if (H || this.options.hasPanel) {
            var B = (bkLib.isMSIE && !((typeof document.body.style.maxHeight != "undefined") && document.compatMode == "CSS1Compat"));
            var E = {
                width: newX + "px",
                border: "1px solid #ccc",
                borderTop: 0,
                overflowY: "auto",
                overflowX: "hidden"
            };
            E[(B) ? "height" : "maxHeight"] = (this.ne.options.maxHeight) ? this.ne.options.maxHeight + "px" : null;
            this.editorContain = new bkElement("DIV").setStyle(E).appendBefore(G);
            var A = new bkElement("DIV").setStyle({
                width: (newX - 8) + "px",
                margin: "4px",
                minHeight: newY + "px"
            }).addClass("main").appendTo(this.editorContain);
            G.setStyle({
                display: "none"
            });
            A.innerHTML = G.innerHTML;
            if (H) {
                A.setContent(G.value);
                this.copyElm = G;
                var F = G.parentTag("FORM");
                if (F) {
                    bkLib.addEvent(F, "submit", this.saveContent.closure(this))
                }
            }
            A.setStyle((B) ? {
                height: newY + "px"
            } : {
                overflow: "hidden"
            });
            this.elm = A
        }
        this.ne.addEvent("blur", this.blur.closure(this));
        this.init();
        this.blur()
    },
    init: function() {
        this.elm.setAttribute("contentEditable", "true");
        if (this.getContent() == "") {
            this.setContent("<br />")
        }
        this.instanceDoc = document.defaultView;
        this.elm.addEvent("mousedown", this.selected.closureListener(this)).addEvent("keypress", this.keyDown.closureListener(this)).addEvent("focus", this.selected.closure(this)).addEvent("blur", this.blur.closure(this)).addEvent("keyup", this.selected.closure(this));
        this.ne.fireEvent("add", this)
    },
    remove: function() {
        this.saveContent();
        if (this.copyElm || this.options.hasPanel) {
            this.editorContain.remove();
            this.e.setStyle({
                display: "block"
            });
            this.ne.removePanel()
        }
        this.disable();
        this.ne.fireEvent("remove", this)
    },
    disable: function() {
        this.elm.setAttribute("contentEditable", "false")
    },
    getSel: function() {
        return (window.getSelection) ? window.getSelection() : document.selection
    },
    getRng: function() {
        var A = this.getSel();
        if (!A || A.rangeCount === 0) {
            return
        }
        return (A.rangeCount > 0) ? A.getRangeAt(0) : A.createRange()
    },
    selRng: function(A, B) {
        if (window.getSelection) {
            B.removeAllRanges();
            B.addRange(A)
        } else {
            A.select()
        }
    },
    selElm: function() {
        var C = this.getRng();
        if (!C) {
            return
        }
        if (C.startContainer) {
            var D = C.startContainer;
            if (C.cloneContents().childNodes.length == 1) {
                for (var B = 0; B < D.childNodes.length; B++) {
                    var A = D.childNodes[B].ownerDocument.createRange();
                    A.selectNode(D.childNodes[B]);
                    if (C.compareBoundaryPoints(Range.START_TO_START, A) != 1 && C.compareBoundaryPoints(Range.END_TO_END, A) != -1) {
                        return $BK(D.childNodes[B])
                    }
                }
            }
            return $BK(D)
        } else {
            return $BK((this.getSel().type == "Control") ? C.item(0) : C.parentElement())
        }
    },
    saveRng: function() {
        this.savedRange = this.getRng();
        this.savedSel = this.getSel()
    },
    restoreRng: function() {
        if (this.savedRange) {
            this.selRng(this.savedRange, this.savedSel)
        }
    },
    keyDown: function(B, A) {
        if (B.ctrlKey) {
            this.ne.fireEvent("key", this, B)
        }
    },
    selected: function(C, A) {
        if (!A && !(A = this.selElm)) {
            A = this.selElm()
        }
        if (!C.ctrlKey) {
            var B = this.ne.selectedInstance;
            if (B != this) {
                if (B) {
                    this.ne.fireEvent("blur", B, A)
                }
                this.ne.selectedInstance = this;
                this.ne.fireEvent("focus", B, A)
            }
            this.ne.fireEvent("selected", B, A);
            this.isFocused = true;
            this.elm.addClass("selected")
        }
        return false
    },
    blur: function() {
        this.isFocused = false;
        this.elm.removeClass("selected")
    },
    saveContent: function() {
        if (this.copyElm || this.options.hasPanel) {
            this.ne.fireEvent("save", this);
            (this.copyElm) ? this.copyElm.value = this.getContent(): this.e.innerHTML = this.getContent()
        }
    },
    getElm: function() {
        return this.elm
    },
    getContent: function() {
        this.content = this.getElm().innerHTML;
        this.ne.fireEvent("get", this);
        return this.content
    },
    setContent: function(A) {
        this.content = A;
        this.ne.fireEvent("set", this);
        this.elm.innerHTML = this.content
    },
    nicCommand: function(B, A) {
        document.execCommand(B, false, A)
    }
});*/

var nicEditorInstance = bkClass.extend({
    isSelected : false,

    construct : function(e,options,nicEditor) {
        this.ne = nicEditor;
        this.elm = this.e = e;
        this.options = options || {};

        newX = parseInt(e.getStyle('width')) || e.clientWidth;
        newY = parseInt(e.getStyle('height')) || e.clientHeight;
        this.initialHeight = newY-8;

        var isTextarea = (e.nodeName.toLowerCase() == "textarea");
        if(isTextarea || this.options.hasPanel) {
            var ie7s = (bkLib.isMSIE && !((typeof document.body.style.maxHeight != "undefined") && document.compatMode == "CSS1Compat"))
            var s = {width: newX+'px', border : '2px solid #F1F1F1', borderTop : 0, overflowY : 'auto', overflowX: 'hidden' };
            s[(ie7s) ? 'height' : 'maxHeight'] = (this.ne.options.maxHeight) ? this.ne.options.maxHeight+'px' : null;
            this.editorContain = new bkElement('DIV').setStyle(s).appendBefore(e);

            /* CLEAN WORD PASTE MOD */
            //var editorElm = new bkElement('DIV').setAttributes({id : e.id}).setStyle({width : (newX-8)+'px', margin: '4px', minHeight : newY+'px'}).addClass('main').appendTo(this.editorContain);
            var editorElm = new bkElement('DIV').setStyle({width : (newX-8)+'px', margin: '4px', minHeight : newY+'px'}).addClass('main').appendTo(this.editorContain);


            e.setStyle({display : 'none'});
            editorElm.innerHTML = e.innerHTML;
            if(isTextarea) {
                editorElm.setContent(e.value);
                this.copyElm = e;
                var f = e.parentTag('FORM');
                if(f) { bkLib.addEvent( f, 'submit', this.saveContent.closure(this)); }
            }
            editorElm.setStyle((ie7s) ? {height : newY+'px'} : {overflow: 'hidden'});
            this.elm = editorElm;

        }
        this.ne.addEvent('blur',this.blur.closure(this));

        this.init();
        this.blur();
    },

    init : function() {
        this.elm.setAttribute('contentEditable','true');
        if(this.getContent() == "") {
            this.setContent('<br />');
        }
        this.instanceDoc = document.defaultView;
        this.elm.addEvent('mousedown',this.selected.closureListener(this)).addEvent('keypress',this.keyDown.closureListener(this)).addEvent('focus',this.selected.closure(this)).addEvent('blur',this.blur.closure(this)).addEvent('keyup',this.selected.closure(this));
        this.ne.fireEvent('add',this);

        /* CLEAN WORD PASTE MOD */
        this.elm.addEvent('paste',this.initPasteClean.closureListener(this));
    },

    initPasteClean : function() {
        this.pasteCache = this.getElm().innerHTML;
        setTimeout(this.pasteClean.closure(this),100);
    },

    /* CLEAN WORD PASTE MOD : pasteClean method added for clean word paste */
    pasteClean : function() {
        var matchedHead = "";
        var matchedTail = "";
        var newContent = this.getElm().innerHTML;
        this.ne.fireEvent("get",this);
        var newContentStart = 0;
        var newContentFinish = 0;
        var newSnippet = "";
        var tempNode = document.createElement("div");

        /* Find start of both strings that matches */

        for (newContentStart = 0; newContent.charAt(newContentStart) == this.pasteCache.charAt(newContentStart); newContentStart++)
        {
            matchedHead += this.pasteCache.charAt(newContentStart);
        }

        /* If newContentStart is inside a HTML tag, move to opening brace of tag */
        for (var i = newContentStart; i >= 0; i--)
        {
            if (this.pasteCache.charAt(i) == "<")
            {
                newContentStart = i;
                matchedHead = this.pasteCache.substring(0, newContentStart);

                break;
            }
            else if(this.pasteCache.charAt(i) == ">")
            {
                break;
            }
        }

        newContent = this.reverse(newContent);
        this.pasteCache = this.reverse(this.pasteCache);

        /* Find end of both strings that matches */
        for (newContentFinish = 0; newContent.charAt(newContentFinish) == this.pasteCache.charAt(newContentFinish); newContentFinish++)
        {
            matchedTail += this.pasteCache.charAt(newContentFinish);
        }

        /* If newContentFinish is inside a HTML tag, move to closing brace of tag */
        for (var i = newContentFinish; i >= 0; i--)
        {
            if (this.pasteCache.charAt(i) == ">")
            {
                newContentFinish = i;
                matchedTail = this.pasteCache.substring(0, newContentFinish);

                break;
            }
            else if(this.pasteCache.charAt(i) == "<")
            {
                break;
            }
        }

        matchedTail = this.reverse(matchedTail);

        /* If there's no difference in pasted content */
        if (newContentStart == newContent.length - newContentFinish)
        {
            return false;
        }

        newContent = this.reverse(newContent);
        newSnippet = newContent.substring(newContentStart, newContent.length - newContentFinish);
        newSnippet = this.validTags(newSnippet);

        /* Replace opening bold tags with strong */
        newSnippet = newSnippet.replace(/<b(\s+|>)/g, "<strong$1");
        /* Replace closing bold tags with closing strong */
        newSnippet = newSnippet.replace(/<\/b(\s+|>)/g, "</strong$1");

        /* Replace italic tags with em */
        newSnippet = newSnippet.replace(/<i(\s+|>)/g, "<em$1");
        /* Replace closing italic tags with closing em */
        newSnippet = newSnippet.replace(/<\/i(\s+|>)/g, "</em$1");

        /* strip out comments -cgCraft */
        newSnippet = newSnippet.replace(/<!(?:--[\s\S]*?--\s*)?>\s*/g, "");

        /* strip out &nbsp; -cgCraft */
        newSnippet = newSnippet.replace(/&nbsp;/gi, " ");
        /* strip out extra spaces -cgCraft */
        newSnippet = newSnippet.replace(/ <\//gi, "</");

        while (newSnippet.indexOf("  ") != -1) {
            var anArray = newSnippet.split("  ")
            newSnippet = anArray.join(" ")
        }

        /* strip &nbsp; -cgCraft */
        newSnippet = newSnippet.replace(/^\s*|\s*$/g, "");

        /* Strip out unaccepted attributes */

        newSnippet = newSnippet.replace(/<[^>]*>/g, function(match)
            {
                match = match.replace(/ ([^=]+)="[^"]*"/g, function(match2, attributeName)
                    {
                        if (attributeName == "alt" || attributeName == "href" || attributeName == "src" || attributeName == "title")
                        {
                            return match2;
                        }

                        return "";
                    });

                return match;
            }
            );

        /* Final cleanout for MS Word cruft */
        newSnippet = newSnippet.replace(/<\?xml[^>]*>/g, "");
        newSnippet = newSnippet.replace(/<[^ >]+:[^>]*>/g, "");
        newSnippet = newSnippet.replace(/<\/[^ >]+:[^>]*>/g, "");

        /* remove undwanted tags */
        newSnippet = newSnippet.replace(/<(div|span|style|meta|link){1}.*?>/gi,'');

        this.content = matchedHead + newSnippet + matchedTail;
        this.ne.fireEvent("set",this);
        this.elm.innerHTML = this.content;
    },

    reverse : function(sentString) {
        var theString = "";
        for (var i = sentString.length - 1; i >= 0; i--) {
            theString += sentString.charAt(i);
        }
        return theString;
    },

    /* CLEAN WORD PASTE MOD : validTags method added for clean word paste */
    validTags : function(snippet) {
        var theString = snippet;

        /* Replace uppercase element names with lowercase */
        theString = theString.replace(/<[^> ]*/g, function(match){return match.toLowerCase();});

        /* Replace uppercase attribute names with lowercase */
        theString = theString.replace(/<[^>]*>/g, function(match) {
            match = match.replace(/ [^=]+=/g, function(match2){return match2.toLowerCase();});
            return match;
        });

        /* Put quotes around unquoted attributes */
        theString = theString.replace(/<[^>]*>/g, function(match) {
            match = match.replace(/( [^=]+=)([^"][^ >]*)/g, "$1\"$2\"");
            return match;
        });

        return theString;
    },

    remove : function() {
        this.saveContent();
        if(this.copyElm || this.options.hasPanel) {
            this.editorContain.remove();
            this.e.setStyle({'display' : 'block'});
            this.ne.removePanel();
        }
        this.disable();
        this.ne.fireEvent('remove',this);
    },

    disable : function() {
        this.elm.setAttribute('contentEditable','false');
    },

    getSel : function() {
        return (window.getSelection) ? window.getSelection() : document.selection;
    },

    getRng : function() {
        var s = this.getSel();
        if(!s) { return null; }
        return (s.rangeCount > 0) ? s.getRangeAt(0) : s.createRange();
    },

    selRng : function(rng,s) {
        if(window.getSelection) {
            s.removeAllRanges();
            s.addRange(rng);
        } else {
            rng.select();
        }
    },

    selElm : function() {
        var r = this.getRng();
        if(r.startContainer) {
            var contain = r.startContainer;
            if(r.cloneContents().childNodes.length == 1) {
                for(var i=0;i<contain.childNodes.length;i++) {
                    var rng = contain.childNodes[i].ownerDocument.createRange();
                    rng.selectNode(contain.childNodes[i]);
                    if(r.compareBoundaryPoints(Range.START_TO_START,rng) != 1 &&
                        r.compareBoundaryPoints(Range.END_TO_END,rng) != -1) {
                        return $BK(contain.childNodes[i]);
                    }
                }
            }
            return $BK(contain);
        } else {
            return $BK((this.getSel().type == "Control") ? r.item(0) : r.parentElement());
        }
    },

    saveRng : function() {
        this.savedRange = this.getRng();
        this.savedSel = this.getSel();
    },

    restoreRng : function() {
        if(this.savedRange) {
            this.selRng(this.savedRange,this.savedSel);
        }
    },

    keyDown : function(e,t) {
        if(e.ctrlKey) {
            this.ne.fireEvent('key',this,e);
        }
    },

    selected : function(e,t) {
        if(!t) {t = this.selElm()}
        if(!e.ctrlKey) {
            var selInstance = this.ne.selectedInstance;
            if(selInstance != this) {
                if(selInstance) {
                    this.ne.fireEvent('blur',selInstance,t);
                }
                this.ne.selectedInstance = this;
                this.ne.fireEvent('focus',selInstance,t);
            }
            this.ne.fireEvent('selected',selInstance,t);
            this.isFocused = true;
            this.elm.addClass('selected');
        }
        return false;
    },

    blur : function() {
        this.isFocused = false;
        this.elm.removeClass('selected');
    },

    saveContent : function() {
        if(this.copyElm || this.options.hasPanel) {
            this.ne.fireEvent('save',this);
            (this.copyElm) ? this.copyElm.value = this.getContent() : this.e.innerHTML = this.getContent();
        }
    },

    getElm : function() {
        return this.elm;
    },

    getContent : function() {
        this.content = this.getElm().innerHTML;
        this.ne.fireEvent('get',this);
        return this.content;
    },

    setContent : function(e) {
        this.content = e;
        this.ne.fireEvent('set',this);
        this.elm.innerHTML = this.content;
    },

    nicCommand : function(cmd,args) {
        document.execCommand(cmd,false,args);
    }
});
var nicEditorIFrameInstance = nicEditorInstance.extend({
    savedStyles: [],
    init: function() {
        var B = this.elm.innerHTML.replace(/^\s+|\s+$/g, "");
        this.elm.innerHTML = "";
        (!B) ? B = "<br />": B;
        this.initialContent = B;
        this.elmFrame = new bkElement("iframe").setAttributes({
            src: "javascript:;",
            frameBorder: 0,
            allowTransparency: "true",
            scrolling: "no"
        }).setStyle({
            height: "100px",
            width: "100%"
        }).addClass("frame").appendTo(this.elm);
        if (this.copyElm) {
            this.elmFrame.setStyle({
                width: (this.elm.offsetWidth - 4) + "px"
            })
        }
        var A = ["font-size", "font-family", "font-weight", "color"];
        for (itm in A) {
            this.savedStyles[bkLib.camelize(itm)] = this.elm.getStyle(itm)
        }
        setTimeout(this.initFrame.closure(this), 50)
    },
    disable: function() {
        this.elm.innerHTML = this.getContent()
    },
    initFrame: function() {
        var B = $BK(this.elmFrame.contentWindow.document);
        B.designMode = "on";
        B.open();
        var A = this.ne.options.externalCSS;
        B.write("<html><head>" + ((A) ? '<link href="' + A + '" rel="stylesheet" type="text/css" />' : "") + '</head><body id="nicEditContent" style="margin: 0 !important; background-color: transparent !important;">' + this.initialContent + "</body></html>");
        B.close();
        this.frameDoc = B;
        this.frameWin = $BK(this.elmFrame.contentWindow);
        this.frameContent = $BK(this.frameWin.document.body).setStyle(this.savedStyles);
        this.instanceDoc = this.frameWin.document.defaultView;
        this.heightUpdate();
        this.frameDoc.addEvent("mousedown", this.selected.closureListener(this)).addEvent("keyup", this.heightUpdate.closureListener(this)).addEvent("keydown", this.keyDown.closureListener(this)).addEvent("keyup", this.selected.closure(this));
        this.ne.fireEvent("add", this)
    },
    getElm: function() {
        return this.frameContent
    },
    setContent: function(A) {
        this.content = A;
        this.ne.fireEvent("set", this);
        this.frameContent.innerHTML = this.content;
        this.heightUpdate()
    },
    getSel: function() {
        return (this.frameWin) ? this.frameWin.getSelection() : this.frameDoc.selection
    },
    heightUpdate: function() {
        this.elmFrame.style.height = Math.max(this.frameContent.offsetHeight, this.initialHeight) + "px"
    },
    nicCommand: function(B, A) {
        this.frameDoc.execCommand(B, false, A);
        setTimeout(this.heightUpdate.closure(this), 100)
    }
});
var nicEditorPanel = bkClass.extend({
    construct: function(E, B, A) {
        this.elm = E;
        this.options = B;
        this.ne = A;
        this.panelButtons = new Array();
        this.buttonList = bkExtend([], this.ne.options.buttonList);
        this.panelContain = new bkElement("DIV").setStyle({
            overflow: "hidden",
            width: "100%",
            border: "1px solid #cccccc",
            backgroundColor: "#efefef"
        }).addClass("panelContain");
        this.panelElm = new bkElement("DIV").setStyle({
            margin: "2px",
            marginTop: "0px",
            zoom: 1,
            overflow: "hidden"
        }).addClass("panel").appendTo(this.panelContain);
        this.panelContain.appendTo(E);
        var C = this.ne.options;
        var D = C.buttons;
        for (button in D) {
            this.addButton(button, C, true)
        }
        this.reorder();
        E.noSelect()
    },
    addButton: function(buttonName, options, noOrder) {
        var button = options.buttons[buttonName];
        var type = (button.type) ? eval("(typeof(" + button.type + ') == "undefined") ? null : ' + button.type + ";") : nicEditorButton;
        var hasButton = bkLib.inArray(this.buttonList, buttonName);
        if (type && (hasButton || this.ne.options.fullPanel)) {
            this.panelButtons.push(new type(this.panelElm, buttonName, options, this.ne));
            if (!hasButton) {
                this.buttonList.push(buttonName)
            }
        }
    },
    findButton: function(B) {
        for (var A = 0; A < this.panelButtons.length; A++) {
            if (this.panelButtons[A].name == B) {
                return this.panelButtons[A]
            }
        }
    },
    reorder: function() {
        var C = this.buttonList;
        for (var B = 0; B < C.length; B++) {
            var A = this.findButton(C[B]);
            if (A) {
                this.panelElm.appendChild(A.margin)
            }
        }
    },
    remove: function() {
        this.elm.remove()
    }
});
var nicEditorButton = bkClass.extend({
    construct: function(D, A, C, B) {
        this.options = C.buttons[A];
        this.name = A;
        this.ne = B;
        this.elm = D;
        this.margin = new bkElement("DIV").setStyle({
            "float": "left",
            marginTop: "2px"
        }).appendTo(D);
        this.contain = new bkElement("DIV").setStyle({
            width: "20px",
            height: "20px"
        }).addClass("buttonContain").appendTo(this.margin);
        this.border = new bkElement("DIV").setStyle({
            backgroundColor: "#efefef",
            border: "1px solid #efefef"
        }).appendTo(this.contain);
        this.button = new bkElement("DIV").setStyle({
            width: "18px",
            height: "18px",
            overflow: "hidden",
            zoom: 1,
            cursor: "pointer"
        }).addClass("button").setStyle(this.ne.getIcon(A, C)).appendTo(this.border);
        this.button.addEvent("mouseover", this.hoverOn.closure(this)).addEvent("mouseout", this.hoverOff.closure(this)).addEvent("mousedown", this.mouseClick.closure(this)).noSelect();
        if (!window.opera) {
            this.button.onmousedown = this.button.onclick = bkLib.cancelEvent
        }
        B.addEvent("selected", this.enable.closure(this)).addEvent("blur", this.disable.closure(this)).addEvent("key", this.key.closure(this));
        this.disable();
        this.init()
    },
    init: function() {},
    hide: function() {
        this.contain.setStyle({
            display: "none"
        })
    },
    updateState: function() {
        if (this.isDisabled) {
            this.setBg()
        } else {
            if (this.isHover) {
                this.setBg("hover")
            } else {
                if (this.isActive) {
                    this.setBg("active")
                } else {
                    this.setBg()
                }
            }
        }
    },
    setBg: function(A) {
        switch (A) {
            case "hover":
                var B = {
                    border: "1px solid #666",
                    backgroundColor: "#ddd"
                };
                break;
            case "active":
                var B = {
                    border: "1px solid #666",
                    backgroundColor: "#ccc"
                };
                break;
            default:
                var B = {
                    border: "1px solid #efefef",
                    backgroundColor: "#efefef"
                }
        }
        this.border.setStyle(B).addClass("button-" + A)
    },
    checkNodes: function(A) {
        var B = A;
        do {
            if (this.options.tags && bkLib.inArray(this.options.tags, B.nodeName)) {
                this.activate();
                return true
            }
        } while (B = B.parentNode && B.className != "nicEdit");
        B = $BK(A);
        while (B.nodeType == 3) {
            B = $BK(B.parentNode)
        }
        if (this.options.css) {
            for (itm in this.options.css) {
                if (B.getStyle(itm, this.ne.selectedInstance.instanceDoc) == this.options.css[itm]) {
                    this.activate();
                    return true
                }
            }
        }
        this.deactivate();
        return false
    },
    activate: function() {
        if (!this.isDisabled) {
            this.isActive = true;
            this.updateState();
            this.ne.fireEvent("buttonActivate", this)
        }
    },
    deactivate: function() {
        this.isActive = false;
        this.updateState();
        if (!this.isDisabled) {
            this.ne.fireEvent("buttonDeactivate", this)
        }
    },
    enable: function(A, B) {
        this.isDisabled = false;
        this.contain.setStyle({
            opacity: 1
        }).addClass("buttonEnabled");
        this.updateState();
        this.checkNodes(B)
    },
    disable: function(A, B) {
        this.isDisabled = true;
        this.contain.setStyle({
            opacity: 0.6
        }).removeClass("buttonEnabled");
        this.updateState()
    },
    toggleActive: function() {
        (this.isActive) ? this.deactivate(): this.activate()
    },
    hoverOn: function() {
        if (!this.isDisabled) {
            this.isHover = true;
            this.updateState();
            this.ne.fireEvent("buttonOver", this)
        }
    },
    hoverOff: function() {
        this.isHover = false;
        this.updateState();
        this.ne.fireEvent("buttonOut", this)
    },
    mouseClick: function() {
        if (this.options.command) {
            this.ne.nicCommand(this.options.command, this.options.commandArgs);
            if (!this.options.noActive) {
                this.toggleActive()
            }
        }
        this.ne.fireEvent("buttonClick", this)
    },
    key: function(A, B) {
        if (this.options.key && B.ctrlKey && String.fromCharCode(B.keyCode || B.charCode).toLowerCase() == this.options.key) {
            this.mouseClick();
            if (B.preventDefault) {
                B.preventDefault()
            }
        }
    }
});
var nicPlugin = bkClass.extend({
    construct: function(B, A) {
        this.options = A;
        this.ne = B;
        this.ne.addEvent("panel", this.loadPanel.closure(this));
        this.init()
    },
    loadPanel: function(C) {
        var B = this.options.buttons;
        for (var A in B) {
            C.addButton(A, this.options)
        }
        C.reorder()
    },
    init: function() {}
});


var nicPaneOptions = {};

var nicEditorPane = bkClass.extend({
    construct: function(D, C, B, A) {
        this.ne = C;
        this.elm = D;
        this.pos = D.pos();
        this.contain = new bkElement("div").setStyle({
            zIndex: "99999",
            overflow: "hidden",
            position: "absolute",
            left: this.pos[0] + "px",
            top: this.pos[1] + "px"
        });
        this.pane = new bkElement("div").setStyle({
            fontSize: "12px",
            border: "1px solid #ccc",
            overflow: "hidden",
            padding: "4px",
            textAlign: "left",
            backgroundColor: "#ffffc9"
        }).addClass("pane").setStyle(B).appendTo(this.contain);
        if (A && !A.options.noClose) {
            this.close = new bkElement("div").setStyle({
                "float": "right",
                height: "16px",
                width: "16px",
                cursor: "pointer"
            }).setStyle(this.ne.getIcon("close", nicPaneOptions)).addEvent("mousedown", A.removePane.closure(this)).appendTo(this.pane)
        }
        this.contain.noSelect().appendTo(document.body);
        this.position();
        this.init()
    },
    init: function() {},
    position: function() {
        if (this.ne.nicPanel) {
            var B = this.ne.nicPanel.elm;
            var A = B.pos();
            var C = A[0] + parseInt(B.getStyle("width")) - (parseInt(this.pane.getStyle("width")) + 8);
            if (C < this.pos[0]) {
                this.contain.setStyle({
                    left: C + "px"
                })
            }
        }
    },
    toggle: function() {
        this.isVisible = !this.isVisible;
        this.contain.setStyle({
            display: ((this.isVisible) ? "block" : "none")
        })
    },
    remove: function() {
        if (this.contain) {
            this.contain.remove();
            this.contain = null
        }
    },
    append: function(A) {
        A.appendTo(this.pane)
    },
    setContent: function(A) {
        this.pane.setContent(A)
    }
});

var nicEditorAdvancedButton = nicEditorButton.extend({
    init: function() {
        this.ne.addEvent("selected", this.removePane.closure(this)).addEvent("blur", this.removePane.closure(this))
    },
    mouseClick: function() {
        if (!this.isDisabled) {
            if (this.pane && this.pane.pane) {
                this.removePane()
            } else {
                this.pane = new nicEditorPane(this.contain, this.ne, {
                    width: (this.width || "270px"),
                    backgroundColor: "#fff"
                }, this);
                this.addPane();
                this.ne.selectedInstance.saveRng()
            }
        }
    },
    addForm: function(C, G) {
        this.form = new bkElement("form").addEvent("submit", this.submit.closureListener(this));
        this.pane.append(this.form);
        this.inputs = {};
        for (itm in C) {
            var D = C[itm];
            var F = "";
            if (G) {
                F = G.getAttribute(itm)
            }
            if (!F) {
                F = D.value || ""
            }
            var A = C[itm].type;
            if (A == "title") {
                new bkElement("div").setContent(D.txt).setStyle({
                    fontSize: "14px",
                    fontWeight: "bold",
                    padding: "0px",
                    margin: "2px 0"
                }).appendTo(this.form)
            } else {
                var B = new bkElement("div").setStyle({
                    overflow: "hidden",
                    clear: "both"
                }).appendTo(this.form);
                if (D.txt) {
                    new bkElement("label").setAttributes({
                        "for": itm
                    }).setContent(D.txt).setStyle({
                        margin: "2px 4px",
                        fontSize: "13px",
                        width: "50px",
                        lineHeight: "20px",
                        textAlign: "right",
                        "float": "left"
                    }).appendTo(B)
                }
                switch (A) {
                    case "text":
                        this.inputs[itm] = new bkElement("input").setAttributes({
                            id: itm,
                            value: F,
                            type: "text"
                        }).setStyle({
                            margin: "2px 0",
                            fontSize: "13px",
                            "float": "left",
                            height: "20px",
                            border: "1px solid #ccc",
                            overflow: "hidden"
                        }).setStyle(D.style).appendTo(B);
                        break;
                    case "select":
                        this.inputs[itm] = new bkElement("select").setAttributes({
                            id: itm
                        }).setStyle({
                            border: "1px solid #ccc",
                            "float": "left",
                            margin: "2px 0"
                        }).appendTo(B);
                        for (opt in D.options) {
                            var E = new bkElement("option").setAttributes({
                                value: opt,
                                selected: (opt == F) ? "selected" : ""
                            }).setContent(D.options[opt]).appendTo(this.inputs[itm])
                        }
                        break;
                    case "content":
                        this.inputs[itm] = new bkElement("textarea").setAttributes({
                            id: itm
                        }).setStyle({
                            border: "1px solid #ccc",
                            "float": "left"
                        }).setStyle(D.style).appendTo(B);
                        this.inputs[itm].value = F
                }
            }
        }
        new bkElement("input").setAttributes({
            type: "submit"
        }).setStyle({
            backgroundColor: "#efefef",
            border: "1px solid #ccc",
            margin: "3px 0",
            "float": "left",
            clear: "both"
        }).appendTo(this.form);
        this.form.onsubmit = bkLib.cancelEvent
    },
    submit: function() {},
    findElm: function(B, A, E) {
        var D = this.ne.selectedInstance.getElm().getElementsByTagName(B);
        for (var C = 0; C < D.length; C++) {
            if (D[C].getAttribute(A) == E) {
                return $BK(D[C])
            }
        }
    },
    removePane: function() {
        if (this.pane) {
            this.pane.remove();
            this.pane = null;
            this.ne.selectedInstance.restoreRng()
        }
    }
});

var nicButtonTips = bkClass.extend({
    construct: function(A) {
        this.ne = A;
        A.addEvent("buttonOver", this.show.closure(this)).addEvent("buttonOut", this.hide.closure(this))
    },
    show: function(A) {
        this.timer = setTimeout(this.create.closure(this, A), 400)
    },
    create: function(A) {
        this.timer = null;
        if (!this.pane) {
            this.pane = new nicEditorPane(A.button, this.ne, {
                fontSize: "12px",
                marginTop: "5px"
            });
            this.pane.setContent(A.options.name)
        }
    },
    hide: function(A) {
        if (this.timer) {
            clearTimeout(this.timer)
        }
        if (this.pane) {
            this.pane = this.pane.remove()
        }
    }
});
nicEditors.registerPlugin(nicButtonTips);


var nicSelectOptions = {
    buttons: {
        'fontSize': {
            name: __('Tamanho'),
            type: 'nicEditorFontSizeSelect',
            command: 'fontsize'
        },
        'fontFamily': {
            name: __('Fonte'),
            type: 'nicEditorFontFamilySelect',
            command: 'fontname'
        },
        'fontFormat': {
            name: __('Formato'),
            type: 'nicEditorFontFormatSelect',
            command: 'formatBlock'
        }
    }
};

var nicEditorSelect = bkClass.extend({
    construct: function(D, A, C, B) {
        this.options = C.buttons[A];
        this.elm = D;
        this.ne = B;
        this.name = A;
        this.selOptions = new Array();
        this.margin = new bkElement("div").setStyle({
            "float": "left",
            margin: "2px 1px 0 1px"
        }).appendTo(this.elm);
        this.contain = new bkElement("div").setStyle({
            width: "90px",
            height: "20px",
            cursor: "pointer",
            overflow: "hidden"
        }).addClass("selectContain").addEvent("click", this.toggle.closure(this)).appendTo(this.margin);
        this.items = new bkElement("div").setStyle({
            overflow: "hidden",
            zoom: 1,
            border: "1px solid #ccc",
            paddingLeft: "3px",
            backgroundColor: "#fff"
        }).appendTo(this.contain);
        this.control = new bkElement("div").setStyle({
            overflow: "hidden",
            "float": "right",
            height: "18px",
            width: "16px"
        }).addClass("selectControl").setStyle(this.ne.getIcon("arrow", C)).appendTo(this.items);
        this.txt = new bkElement("div").setStyle({
            overflow: "hidden",
            "float": "left",
            width: "66px",
            height: "14px",
            marginTop: "1px",
            fontFamily: "sans-serif",
            textAlign: "center",
            fontSize: "12px"
        }).addClass("selectTxt").appendTo(this.items);
        if (!window.opera) {
            this.contain.onmousedown = this.control.onmousedown = this.txt.onmousedown = bkLib.cancelEvent
        }
        this.margin.noSelect();
        this.ne.addEvent("selected", this.enable.closure(this)).addEvent("blur", this.disable.closure(this));
        this.disable();
        this.init()
    },
    disable: function() {
        this.isDisabled = true;
        this.close();
        this.contain.setStyle({
            opacity: 0.6
        })
    },
    enable: function(A) {
        this.isDisabled = false;
        this.close();
        this.contain.setStyle({
            opacity: 1
        })
    },
    setDisplay: function(A) {
        this.txt.setContent(A)
    },
    toggle: function() {
        if (!this.isDisabled) {
            (this.pane) ? this.close(): this.open()
        }
    },
    open: function() {
        this.pane = new nicEditorPane(this.items, this.ne, {
            width: "88px",
            padding: "0px",
            borderTop: 0,
            borderLeft: "1px solid #ccc",
            borderRight: "1px solid #ccc",
            borderBottom: "0px",
            backgroundColor: "#fff"
        });
        for (var C = 0; C < this.selOptions.length; C++) {
            var B = this.selOptions[C];
            var A = new bkElement("div").setStyle({
                overflow: "hidden",
                borderBottom: "1px solid #ccc",
                width: "88px",
                textAlign: "left",
                overflow: "hidden",
                cursor: "pointer"
            });
            var D = new bkElement("div").setStyle({
                padding: "0px 4px"
            }).setContent(B[1]).appendTo(A).noSelect();
            D.addEvent("click", this.update.closure(this, B[0])).addEvent("mouseover", this.over.closure(this, D)).addEvent("mouseout", this.out.closure(this, D)).setAttributes("id", B[0]);
            this.pane.append(A);
            if (!window.opera) {
                D.onmousedown = bkLib.cancelEvent
            }
        }
    },
    close: function() {
        if (this.pane) {
            this.pane = this.pane.remove()
        }
    },
    over: function(A) {
        A.setStyle({
            backgroundColor: "#ccc"
        })
    },
    out: function(A) {
        A.setStyle({
            backgroundColor: "#fff"
        })
    },
    add: function(B, A) {
        this.selOptions.push(new Array(B, A))
    },
    update: function(A) {
        this.ne.nicCommand(this.options.command, A);
        this.close()
    }
});
var nicEditorFontSizeSelect = nicEditorSelect.extend({
    sel: {
        1: "1&nbsp;(8pt)",
        2: "2&nbsp;(10pt)",
        3: "3&nbsp;(12pt)",
        4: "4&nbsp;(14pt)",
        5: "5&nbsp;(18pt)",
        6: "6&nbsp;(24pt)"
    },
    init: function() {
        this.setDisplay("Tamanho...");
        for (itm in this.sel) {
            this.add(itm, '<font size="' + itm + '">' + this.sel[itm] + "</font>")
        }
    }
});
var nicEditorFontFamilySelect = nicEditorSelect.extend({
    sel: {
        arial: "Arial",
        "comic sans ms": "Comic Sans",
        "courier new": "Courier New",
        georgia: "Georgia",
        helvetica: "Helvetica",
        impact: "Impact",
        "times new roman": "Times",
        "trebuchet ms": "Trebuchet",
        verdana: "Verdana"
    },
    init: function() {
        this.setDisplay("Fonte...");
        for (itm in this.sel) {
            this.add(itm, '<font face="' + itm + '">' + this.sel[itm] + "</font>")
        }
    }
});
var nicEditorFontFormatSelect = nicEditorSelect.extend({
    sel: {
        p: "Paragraph",
        pre: "Pre",
        h6: "Heading&nbsp;6",
        h5: "Heading&nbsp;5",
        h4: "Heading&nbsp;4",
        h3: "Heading&nbsp;3",
        h2: "Heading&nbsp;2",
        h1: "Heading&nbsp;1"
    },
    init: function() {
        this.setDisplay("Formato...");
        for (itm in this.sel) {
            var A = itm.toUpperCase();
            this.add("<" + A + ">", "<" + itm + ' style="padding: 0px; margin: 0px;">' + this.sel[itm] + "</" + A + ">")
        }
    }
});
nicEditors.registerPlugin(nicPlugin, nicSelectOptions);


var nicLinkOptions = {
    buttons: {
        'link': {
            name: 'Adicionar link',
            type: 'nicLinkButton',
            tags: ['A']
        },
        'unlink': {
            name: 'Remover link',
            command: 'unlink',
            noActive: true
        }
    }
};

var nicLinkButton = nicEditorAdvancedButton.extend({
    addPane: function() {
        this.ln = this.ne.selectedInstance.selElm().parentTag("A");
        this.addForm({
            "": {
                type: "title",
                txt: "Adicionar/Editar link"
            },
            href: {
                type: "text",
                txt: "URL",
                value: "http://",
                style: {
                    width: "150px"
                }
            },
            title: {
                type: "text",
                txt: "Title"
            },
            target: {
                type: "select",
                txt: "Abrir em",
                options: {
                    "": "Janela atual",
                    _blank: "Nova janela"
                },
                style: {
                    width: "100px"
                }
            }
        }, this.ln)
    },
    submit: function(C) {
        var A = this.inputs.href.value;
        if (A == "http://" || A == "") {
            alert("Você precisa digitar o link URL para criar um link!");
            return false
        }
        this.removePane();
        if (!this.ln) {
            var B = "javascript:nicTemp();";
            this.ne.nicCommand("createlink", B);
            this.ln = this.findElm("A", "href", B)
        }
        if (this.ln) {
            this.ln.setAttributes({
                href: this.inputs.href.value,
                title: this.inputs.title.value,
                target: this.inputs.target.options[this.inputs.target.selectedIndex].value
            })
        }
    }
});
nicEditors.registerPlugin(nicPlugin, nicLinkOptions);


var nicColorOptions = {
    buttons: {
        'forecolor': {
            name: __('Cor do texto'),
            type: 'nicEditorColorButton',
            noClose: true
        },
        'bgcolor': {
            name: __('Cor de fundo'),
            type: 'nicEditorBgColorButton',
            noClose: true
        }
    }
};

var nicEditorColorButton = nicEditorAdvancedButton.extend({
    addPane: function() {
        var D = {
            0: "00",
            1: "33",
            2: "66",
            3: "99",
            4: "CC",
            5: "FF"
        };
        var H = new bkElement("DIV").setStyle({
            width: "270px"
        });
        for (var A in D) {
            for (var F in D) {
                for (var E in D) {
                    var I = "#" + D[A] + D[E] + D[F];
                    var C = new bkElement("DIV").setStyle({
                        cursor: "pointer",
                        height: "15px",
                        "float": "left"
                    }).appendTo(H);
                    var G = new bkElement("DIV").setStyle({
                        border: "2px solid " + I
                    }).appendTo(C);
                    var B = new bkElement("DIV").setStyle({
                        backgroundColor: I,
                        overflow: "hidden",
                        width: "11px",
                        height: "11px"
                    }).addEvent("click", this.colorSelect.closure(this, I)).addEvent("mouseover", this.on.closure(this, G)).addEvent("mouseout", this.off.closure(this, G, I)).appendTo(G);
                    if (!window.opera) {
                        C.onmousedown = B.onmousedown = bkLib.cancelEvent
                    }
                }
            }
        }
        this.pane.append(H.noSelect())
    },
    colorSelect: function(A) {
        this.ne.nicCommand("foreColor", A);
        this.removePane()
    },
    on: function(A) {
        A.setStyle({
            border: "2px solid #000"
        })
    },
    off: function(A, B) {
        A.setStyle({
            border: "2px solid " + B
        })
    }
});
var nicEditorBgColorButton = nicEditorColorButton.extend({
    colorSelect: function(A) {
        this.ne.nicCommand("hiliteColor", A);
        this.removePane()
    }
});
nicEditors.registerPlugin(nicPlugin, nicColorOptions);


var nicImageOptions = {
    buttons: {
        'image': {
            name: 'Adicionar imagem',
            type: 'nicImageButton',
            tags: ['IMG']
        }
    }

};

var nicImageButton = nicEditorAdvancedButton.extend({
    addPane: function() {
        this.im = this.ne.selectedInstance.selElm().parentTag("IMG");
        this.addForm({
            "": {
                type: "title",
                txt: "Adicionar/Editar imagem"
            },
            src: {
                type: "text",
                txt: "URL",
                value: "http://",
                style: {
                    width: "150px"
                }
            },
            alt: {
                type: "text",
                txt: "Legenda",
                style: {
                    width: "100px"
                }
            },
            align: {
                type: "select",
                txt: "Alinhamento",
                options: {
                    none: "Padrão",
                    left: "Esquerda",
                    right: "Direita"
                }
            }
        }, this.im)
    },
    submit: function(B) {
        var C = this.inputs.src.value;
        if (C == "" || C == "http://") {
            alert("Você precisa digitar o link URL da imagem para adicioná-la!");
            return false
        }
        this.removePane();
        if (!this.im) {
            var A = "javascript:nicImTemp();";
            this.ne.nicCommand("insertImage", A);
            this.im = this.findElm("IMG", "src", A)
        }
        if (this.im) {
            this.im.setAttributes({
                src: this.inputs.src.value,
                alt: this.inputs.alt.value,
                align: this.inputs.align.value
            })
        }
    }
});
nicEditors.registerPlugin(nicPlugin, nicImageOptions);


var nicSaveOptions = {
    buttons: {
        'save': {
            name: __('Salvar este conteúdo'),
            type: 'nicEditorSaveButton'
        }
    }
};

var nicEditorSaveButton = nicEditorButton.extend({
    init: function() {
        if (!this.ne.options.onSave) {
            this.margin.setStyle({
                display: "none"
            })
        }
    },
    mouseClick: function() {
        var B = this.ne.options.onSave;
        var A = this.ne.selectedInstance;
        B(A.getContent(), A.elm.id, A)
    }
});
nicEditors.registerPlugin(nicPlugin, nicSaveOptions);