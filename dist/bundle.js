/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/js/block.js":
/*!****************************!*\
  !*** ./assets/js/block.js ***!
  \****************************/
/***/ (() => {

eval("var registerBlockType = wp.blocks.registerBlockType;\nvar InspectorControls = wp.blockEditor.InspectorControls;\nvar _wp$components = wp.components,\n  PanelBody = _wp$components.PanelBody,\n  ToggleControl = _wp$components.ToggleControl;\nvar _wp$element = wp.element,\n  useState = _wp$element.useState,\n  useEffect = _wp$element.useEffect;\nregisterBlockType('custom-miusage-block/miusage-block', {\n  title: 'Miusage Block',\n  icon: 'smiley',\n  category: 'common',\n  attributes: {\n    data: {\n      type: 'array',\n      \"default\": []\n    },\n    showColumn1: {\n      type: 'boolean',\n      \"default\": true\n    },\n    showColumn2: {\n      type: 'boolean',\n      \"default\": true\n    }\n    // Add more attributes for each column visibility control.\n  },\n\n  edit: function edit(props) {\n    var attributes = props.attributes,\n      setAttributes = props.setAttributes;\n    var data = attributes.data,\n      showColumn1 = attributes.showColumn1,\n      showColumn2 = attributes.showColumn2;\n\n    // Fetch data from your AJAX endpoint.\n    useEffect(function () {\n      // Your AJAX fetch logic here.\n    }, []);\n    return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement(InspectorControls, null, /*#__PURE__*/React.createElement(PanelBody, {\n      title: \"Column Visibility\"\n    }, /*#__PURE__*/React.createElement(ToggleControl, {\n      label: \"Show Column 1\",\n      checked: showColumn1,\n      onChange: function onChange() {\n        return setAttributes({\n          showColumn1: !showColumn1\n        });\n      }\n    }), /*#__PURE__*/React.createElement(ToggleControl, {\n      label: \"Show Column 2\",\n      checked: showColumn2,\n      onChange: function onChange() {\n        return setAttributes({\n          showColumn2: !showColumn2\n        });\n      }\n    }))), /*#__PURE__*/React.createElement(\"div\", {\n      className: \"miusage-block\"\n    }));\n  },\n  save: function save() {\n    // The save function is usually used to output content from the block.\n    return null;\n  }\n});\n\n//# sourceURL=webpack://varun/./assets/js/block.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./assets/js/block.js"]();
/******/ 	
/******/ })()
;