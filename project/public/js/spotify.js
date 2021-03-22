/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@babel/runtime/regenerator/index.js":
/*!**********************************************************!*\
  !*** ./node_modules/@babel/runtime/regenerator/index.js ***!
  \**********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__(/*! regenerator-runtime */ "./node_modules/regenerator-runtime/runtime.js");


/***/ }),

/***/ "./node_modules/regenerator-runtime/runtime.js":
/*!*****************************************************!*\
  !*** ./node_modules/regenerator-runtime/runtime.js ***!
  \*****************************************************/
/***/ ((module) => {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

var runtime = (function (exports) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function define(obj, key, value) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
    return obj[key];
  }
  try {
    // IE 8 has a broken Object.defineProperty that only works on DOM objects.
    define({}, "");
  } catch (err) {
    define = function(obj, key, value) {
      return obj[key] = value;
    };
  }

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  exports.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  IteratorPrototype[iteratorSymbol] = function () {
    return this;
  };

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = Gp.constructor = GeneratorFunctionPrototype;
  GeneratorFunctionPrototype.constructor = GeneratorFunction;
  GeneratorFunction.displayName = define(
    GeneratorFunctionPrototype,
    toStringTagSymbol,
    "GeneratorFunction"
  );

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      define(prototype, method, function(arg) {
        return this._invoke(method, arg);
      });
    });
  }

  exports.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  exports.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      define(genFun, toStringTagSymbol, "GeneratorFunction");
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  exports.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator, PromiseImpl) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return PromiseImpl.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return PromiseImpl.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration.
          result.value = unwrapped;
          resolve(result);
        }, function(error) {
          // If a rejected Promise was yielded, throw the rejection back
          // into the async generator function so it can be handled there.
          return invoke("throw", error, resolve, reject);
        });
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new PromiseImpl(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  AsyncIterator.prototype[asyncIteratorSymbol] = function () {
    return this;
  };
  exports.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  exports.async = function(innerFn, outerFn, self, tryLocsList, PromiseImpl) {
    if (PromiseImpl === void 0) PromiseImpl = Promise;

    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList),
      PromiseImpl
    );

    return exports.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        // Note: ["return"] must be used for ES3 parsing compatibility.
        if (delegate.iterator["return"]) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  define(Gp, toStringTagSymbol, "Generator");

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  Gp[iteratorSymbol] = function() {
    return this;
  };

  Gp.toString = function() {
    return "[object Generator]";
  };

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  exports.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  exports.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };

  // Regardless of whether this script is executing as a CommonJS module
  // or not, return the runtime object so that we can declare the variable
  // regeneratorRuntime in the outer scope, which allows this module to be
  // injected easily by `bin/regenerator --include-runtime script.js`.
  return exports;

}(
  // If this script is executing as a CommonJS module, use module.exports
  // as the regeneratorRuntime namespace. Otherwise create a new empty
  // object. Either way, the resulting object will be used to initialize
  // the regeneratorRuntime variable at the top of this file.
   true ? module.exports : 0
));

try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  // This module should not be running in strict mode, so the above
  // assignment should always work unless something is misconfigured. Just
  // in case runtime.js accidentally runs in strict mode, we can escape
  // strict mode using a global Function call. This could conceivably fail
  // if a Content Security Policy forbids using Function, but in that case
  // the proper solution is to fix the accidental strict mode problem. If
  // you've misconfigured your bundler to force strict mode and applied a
  // CSP to forbid Function, and you're not willing to fix either of those
  // problems, please detail your unique predicament in a GitHub issue.
  Function("r", "regeneratorRuntime = r")(runtime);
}


/***/ }),

/***/ "./node_modules/spotify-web-api-js/src/spotify-web-api.js":
/*!****************************************************************!*\
  !*** ./node_modules/spotify-web-api-js/src/spotify-web-api.js ***!
  \****************************************************************/
/***/ ((module) => {

"use strict";
/* global module */


/**
 * Class representing the API
 */
var SpotifyWebApi = (function () {
  var _baseUri = 'https://api.spotify.com/v1';
  var _accessToken = null;
  var _promiseImplementation = null;

  var WrapPromiseWithAbort = function (promise, onAbort) {
    promise.abort = onAbort;
    return promise;
  };

  var _promiseProvider = function (promiseFunction, onAbort) {
    var returnedPromise;
    if (_promiseImplementation !== null) {
      var deferred = _promiseImplementation.defer();
      promiseFunction(
        function (resolvedResult) {
          deferred.resolve(resolvedResult);
        },
        function (rejectedResult) {
          deferred.reject(rejectedResult);
        }
      );
      returnedPromise = deferred.promise;
    } else {
      if (window.Promise) {
        returnedPromise = new window.Promise(promiseFunction);
      }
    }

    if (returnedPromise) {
      return new WrapPromiseWithAbort(returnedPromise, onAbort);
    } else {
      return null;
    }
  };

  var _extend = function () {
    var args = Array.prototype.slice.call(arguments);
    var target = args[0];
    var objects = args.slice(1);
    target = target || {};
    objects.forEach(function (object) {
      for (var j in object) {
        if (object.hasOwnProperty(j)) {
          target[j] = object[j];
        }
      }
    });
    return target;
  };

  var _buildUrl = function (url, parameters) {
    var qs = '';
    for (var key in parameters) {
      if (parameters.hasOwnProperty(key)) {
        var value = parameters[key];
        qs += encodeURIComponent(key) + '=' + encodeURIComponent(value) + '&';
      }
    }
    if (qs.length > 0) {
      // chop off last '&'
      qs = qs.substring(0, qs.length - 1);
      url = url + '?' + qs;
    }
    return url;
  };

  var _performRequest = function (requestData, callback) {
    var req = new XMLHttpRequest();

    var promiseFunction = function (resolve, reject) {
      function success(data) {
        if (resolve) {
          resolve(data);
        }
        if (callback) {
          callback(null, data);
        }
      }

      function failure() {
        if (reject) {
          reject(req);
        }
        if (callback) {
          callback(req, null);
        }
      }

      var type = requestData.type || 'GET';
      req.open(type, _buildUrl(requestData.url, requestData.params));
      if (_accessToken) {
        req.setRequestHeader('Authorization', 'Bearer ' + _accessToken);
      }

      req.onreadystatechange = function () {
        if (req.readyState === 4) {
          var data = null;
          try {
            data = req.responseText ? JSON.parse(req.responseText) : '';
          } catch (e) {
            console.error(e);
          }

          if (req.status >= 200 && req.status < 300) {
            success(data);
          } else {
            failure();
          }
        }
      };

      if (type === 'GET') {
        req.send(null);
      } else {
        var postData = null;
        if (requestData.postData) {
          if (requestData.contentType === 'image/jpeg') {
            postData = requestData.postData;
            req.setRequestHeader('Content-Type', requestData.contentType);
          } else {
            postData = JSON.stringify(requestData.postData);
            req.setRequestHeader('Content-Type', 'application/json');
          }
        }
        req.send(postData);
      }
    };

    if (callback) {
      promiseFunction();
      return null;
    } else {
      return _promiseProvider(promiseFunction, function () {
        req.abort();
      });
    }
  };

  var _checkParamsAndPerformRequest = function (
    requestData,
    options,
    callback,
    optionsAlwaysExtendParams
  ) {
    var opt = {};
    var cb = null;

    if (typeof options === 'object') {
      opt = options;
      cb = callback;
    } else if (typeof options === 'function') {
      cb = options;
    }

    // options extend postData, if any. Otherwise they extend parameters sent in the url
    var type = requestData.type || 'GET';
    if (type !== 'GET' && requestData.postData && !optionsAlwaysExtendParams) {
      requestData.postData = _extend(requestData.postData, opt);
    } else {
      requestData.params = _extend(requestData.params, opt);
    }
    return _performRequest(requestData, cb);
  };

  /**
   * Creates an instance of the wrapper
   * @constructor
   */
  var Constr = function () {};

  Constr.prototype = {
    constructor: SpotifyWebApi
  };

  /**
   * Fetches a resource through a generic GET request.
   *
   * @param {string} url The URL to be fetched
   * @param {function(Object,Object)} callback An optional callback
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getGeneric = function (url, callback) {
    var requestData = {
      url: url
    };
    return _checkParamsAndPerformRequest(requestData, callback);
  };

  /**
   * Fetches information about the current user.
   * See [Get Current User's Profile](https://developer.spotify.com/web-api/get-current-users-profile/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getMe = function (options, callback) {
    var requestData = {
      url: _baseUri + '/me'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches current user's saved tracks.
   * See [Get Current User's Saved Tracks](https://developer.spotify.com/web-api/get-users-saved-tracks/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getMySavedTracks = function (options, callback) {
    var requestData = {
      url: _baseUri + '/me/tracks'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Adds a list of tracks to the current user's saved tracks.
   * See [Save Tracks for Current User](https://developer.spotify.com/web-api/save-tracks-user/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} trackIds The ids of the tracks. If you know their Spotify URI it is easy
   * to find their track id (e.g. spotify:track:<here_is_the_track_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.addToMySavedTracks = function (trackIds, options, callback) {
    var requestData = {
      url: _baseUri + '/me/tracks',
      type: 'PUT',
      postData: trackIds
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Remove a list of tracks from the current user's saved tracks.
   * See [Remove Tracks for Current User](https://developer.spotify.com/web-api/remove-tracks-user/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} trackIds The ids of the tracks. If you know their Spotify URI it is easy
   * to find their track id (e.g. spotify:track:<here_is_the_track_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.removeFromMySavedTracks = function (
    trackIds,
    options,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/me/tracks',
      type: 'DELETE',
      postData: trackIds
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Checks if the current user's saved tracks contains a certain list of tracks.
   * See [Check Current User's Saved Tracks](https://developer.spotify.com/web-api/check-users-saved-tracks/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} trackIds The ids of the tracks. If you know their Spotify URI it is easy
   * to find their track id (e.g. spotify:track:<here_is_the_track_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.containsMySavedTracks = function (
    trackIds,
    options,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/me/tracks/contains',
      params: { ids: trackIds.join(',') }
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Get a list of the albums saved in the current Spotify user's "Your Music" library.
   * See [Get Current User's Saved Albums](https://developer.spotify.com/web-api/get-users-saved-albums/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getMySavedAlbums = function (options, callback) {
    var requestData = {
      url: _baseUri + '/me/albums'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Save one or more albums to the current user's "Your Music" library.
   * See [Save Albums for Current User](https://developer.spotify.com/web-api/save-albums-user/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} albumIds The ids of the albums. If you know their Spotify URI, it is easy
   * to find their album id (e.g. spotify:album:<here_is_the_album_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.addToMySavedAlbums = function (albumIds, options, callback) {
    var requestData = {
      url: _baseUri + '/me/albums',
      type: 'PUT',
      postData: albumIds
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Remove one or more albums from the current user's "Your Music" library.
   * See [Remove Albums for Current User](https://developer.spotify.com/web-api/remove-albums-user/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} albumIds The ids of the albums. If you know their Spotify URI, it is easy
   * to find their album id (e.g. spotify:album:<here_is_the_album_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.removeFromMySavedAlbums = function (
    albumIds,
    options,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/me/albums',
      type: 'DELETE',
      postData: albumIds
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Check if one or more albums is already saved in the current Spotify user's "Your Music" library.
   * See [Check User's Saved Albums](https://developer.spotify.com/web-api/check-users-saved-albums/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} albumIds The ids of the albums. If you know their Spotify URI, it is easy
   * to find their album id (e.g. spotify:album:<here_is_the_album_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.containsMySavedAlbums = function (
    albumIds,
    options,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/me/albums/contains',
      params: { ids: albumIds.join(',') }
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Get the current user’s top artists based on calculated affinity.
   * See [Get a User’s Top Artists](https://developer.spotify.com/web-api/get-users-top-artists-and-tracks/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getMyTopArtists = function (options, callback) {
    var requestData = {
      url: _baseUri + '/me/top/artists'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Get the current user’s top tracks based on calculated affinity.
   * See [Get a User’s Top Tracks](https://developer.spotify.com/web-api/get-users-top-artists-and-tracks/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getMyTopTracks = function (options, callback) {
    var requestData = {
      url: _baseUri + '/me/top/tracks'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Get tracks from the current user’s recently played tracks.
   * See [Get Current User’s Recently Played Tracks](https://developer.spotify.com/web-api/web-api-personalization-endpoints/get-recently-played/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getMyRecentlyPlayedTracks = function (options, callback) {
    var requestData = {
      url: _baseUri + '/me/player/recently-played'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Adds the current user as a follower of one or more other Spotify users.
   * See [Follow Artists or Users](https://developer.spotify.com/web-api/follow-artists-users/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} userIds The ids of the users. If you know their Spotify URI it is easy
   * to find their user id (e.g. spotify:user:<here_is_the_user_id>)
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is an empty value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.followUsers = function (userIds, callback) {
    var requestData = {
      url: _baseUri + '/me/following/',
      type: 'PUT',
      params: {
        ids: userIds.join(','),
        type: 'user'
      }
    };
    return _checkParamsAndPerformRequest(requestData, callback);
  };

  /**
   * Adds the current user as a follower of one or more artists.
   * See [Follow Artists or Users](https://developer.spotify.com/web-api/follow-artists-users/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} artistIds The ids of the artists. If you know their Spotify URI it is easy
   * to find their artist id (e.g. spotify:artist:<here_is_the_artist_id>)
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is an empty value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.followArtists = function (artistIds, callback) {
    var requestData = {
      url: _baseUri + '/me/following/',
      type: 'PUT',
      params: {
        ids: artistIds.join(','),
        type: 'artist'
      }
    };
    return _checkParamsAndPerformRequest(requestData, callback);
  };

  /**
   * Add the current user as a follower of one playlist.
   * See [Follow a Playlist](https://developer.spotify.com/web-api/follow-playlist/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:user:xxxx:playlist:<here_is_the_playlist_id>)
   * @param {Object} options A JSON object with options that can be passed. For instance,
   * whether you want the playlist to be followed privately ({public: false})
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is an empty value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.followPlaylist = function (playlistId, options, callback) {
    var requestData = {
      url: _baseUri + '/playlists/' + playlistId + '/followers',
      type: 'PUT',
      postData: {}
    };

    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Removes the current user as a follower of one or more other Spotify users.
   * See [Unfollow Artists or Users](https://developer.spotify.com/web-api/unfollow-artists-users/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} userIds The ids of the users. If you know their Spotify URI it is easy
   * to find their user id (e.g. spotify:user:<here_is_the_user_id>)
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is an empty value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.unfollowUsers = function (userIds, callback) {
    var requestData = {
      url: _baseUri + '/me/following/',
      type: 'DELETE',
      params: {
        ids: userIds.join(','),
        type: 'user'
      }
    };
    return _checkParamsAndPerformRequest(requestData, callback);
  };

  /**
   * Removes the current user as a follower of one or more artists.
   * See [Unfollow Artists or Users](https://developer.spotify.com/web-api/unfollow-artists-users/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} artistIds The ids of the artists. If you know their Spotify URI it is easy
   * to find their artist id (e.g. spotify:artist:<here_is_the_artist_id>)
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is an empty value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.unfollowArtists = function (artistIds, callback) {
    var requestData = {
      url: _baseUri + '/me/following/',
      type: 'DELETE',
      params: {
        ids: artistIds.join(','),
        type: 'artist'
      }
    };
    return _checkParamsAndPerformRequest(requestData, callback);
  };

  /**
   * Remove the current user as a follower of one playlist.
   * See [Unfollow a Playlist](https://developer.spotify.com/web-api/unfollow-playlist/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:user:xxxx:playlist:<here_is_the_playlist_id>)
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is an empty value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.unfollowPlaylist = function (playlistId, callback) {
    var requestData = {
      url: _baseUri + '/playlists/' + playlistId + '/followers',
      type: 'DELETE'
    };
    return _checkParamsAndPerformRequest(requestData, callback);
  };

  /**
   * Checks to see if the current user is following one or more other Spotify users.
   * See [Check if Current User Follows Users or Artists](https://developer.spotify.com/web-api/check-current-user-follows/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} userIds The ids of the users. If you know their Spotify URI it is easy
   * to find their user id (e.g. spotify:user:<here_is_the_user_id>)
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is an array of boolean values that indicate
   * whether the user is following the users sent in the request.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.isFollowingUsers = function (userIds, callback) {
    var requestData = {
      url: _baseUri + '/me/following/contains',
      type: 'GET',
      params: {
        ids: userIds.join(','),
        type: 'user'
      }
    };
    return _checkParamsAndPerformRequest(requestData, callback);
  };

  /**
   * Checks to see if the current user is following one or more artists.
   * See [Check if Current User Follows](https://developer.spotify.com/web-api/check-current-user-follows/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} artistIds The ids of the artists. If you know their Spotify URI it is easy
   * to find their artist id (e.g. spotify:artist:<here_is_the_artist_id>)
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is an array of boolean values that indicate
   * whether the user is following the artists sent in the request.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.isFollowingArtists = function (artistIds, callback) {
    var requestData = {
      url: _baseUri + '/me/following/contains',
      type: 'GET',
      params: {
        ids: artistIds.join(','),
        type: 'artist'
      }
    };
    return _checkParamsAndPerformRequest(requestData, callback);
  };

  /**
   * Check to see if one or more Spotify users are following a specified playlist.
   * See [Check if Users Follow a Playlist](https://developer.spotify.com/web-api/check-user-following-playlist/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:user:xxxx:playlist:<here_is_the_playlist_id>)
   * @param {Array<string>} userIds The ids of the users. If you know their Spotify URI it is easy
   * to find their user id (e.g. spotify:user:<here_is_the_user_id>)
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is an array of boolean values that indicate
   * whether the users are following the playlist sent in the request.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.areFollowingPlaylist = function (
    playlistId,
    userIds,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/playlists/' + playlistId + '/followers/contains',
      type: 'GET',
      params: {
        ids: userIds.join(',')
      }
    };
    return _checkParamsAndPerformRequest(requestData, callback);
  };

  /**
   * Get the current user's followed artists.
   * See [Get User's Followed Artists](https://developer.spotify.com/web-api/get-followed-artists/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} [options] Options, being after and limit.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is an object with a paged object containing
   * artists.
   * @returns {Promise|undefined} A promise that if successful, resolves to an object containing a paging object which contains
   * artists objects. Not returned if a callback is given.
   */
  Constr.prototype.getFollowedArtists = function (options, callback) {
    var requestData = {
      url: _baseUri + '/me/following',
      type: 'GET',
      params: {
        type: 'artist'
      }
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches information about a specific user.
   * See [Get a User's Profile](https://developer.spotify.com/web-api/get-users-profile/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} userId The id of the user. If you know the Spotify URI it is easy
   * to find the id (e.g. spotify:user:<here_is_the_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getUser = function (userId, options, callback) {
    var requestData = {
      url: _baseUri + '/users/' + encodeURIComponent(userId)
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches a list of the current user's playlists.
   * See [Get a List of a User's Playlists](https://developer.spotify.com/web-api/get-list-users-playlists/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} userId An optional id of the user. If you know the Spotify URI it is easy
   * to find the id (e.g. spotify:user:<here_is_the_id>). If not provided, the id of the user that granted
   * the permissions will be used.
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getUserPlaylists = function (userId, options, callback) {
    var requestData;
    if (typeof userId === 'string') {
      requestData = {
        url: _baseUri + '/users/' + encodeURIComponent(userId) + '/playlists'
      };
    } else {
      requestData = {
        url: _baseUri + '/me/playlists'
      };
      callback = options;
      options = userId;
    }
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches a specific playlist.
   * See [Get a Playlist](https://developer.spotify.com/web-api/get-playlist/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:user:xxxx:playlist:<here_is_the_playlist_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getPlaylist = function (playlistId, options, callback) {
    var requestData = {
      url: _baseUri + '/playlists/' + playlistId
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches the tracks from a specific playlist.
   * See [Get a Playlist's Tracks](https://developer.spotify.com/web-api/get-playlists-tracks/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:user:xxxx:playlist:<here_is_the_playlist_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getPlaylistTracks = function (
    playlistId,
    options,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/playlists/' + playlistId + '/tracks'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Gets the current image associated with a specific playlist.
   * See [Get a Playlist Cover Image](https://developer.spotify.com/documentation/web-api/reference/playlists/get-playlist-cover/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:playlist:<here_is_the_playlist_id>)
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getPlaylistCoverImage = function (playlistId, callback) {
    var requestData = {
      url: _baseUri + '/playlists/' + playlistId + '/images'
    };
    return _checkParamsAndPerformRequest(requestData, callback);
  };

  /**
   * Creates a playlist and stores it in the current user's library.
   * See [Create a Playlist](https://developer.spotify.com/web-api/create-playlist/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} userId The id of the user. If you know the Spotify URI it is easy
   * to find the id (e.g. spotify:user:<here_is_the_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.createPlaylist = function (userId, options, callback) {
    var requestData = {
      url: _baseUri + '/users/' + encodeURIComponent(userId) + '/playlists',
      type: 'POST',
      postData: options
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Change a playlist's name and public/private state
   * See [Change a Playlist's Details](https://developer.spotify.com/web-api/change-playlist-details/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:user:xxxx:playlist:<here_is_the_playlist_id>)
   * @param {Object} data A JSON object with the data to update. E.g. {name: 'A new name', public: true}
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.changePlaylistDetails = function (
    playlistId,
    data,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/playlists/' + playlistId,
      type: 'PUT',
      postData: data
    };
    return _checkParamsAndPerformRequest(requestData, data, callback);
  };

  /**
   * Add tracks to a playlist.
   * See [Add Tracks to a Playlist](https://developer.spotify.com/web-api/add-tracks-to-playlist/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:user:xxxx:playlist:<here_is_the_playlist_id>)
   * @param {Array<string>} uris An array of Spotify URIs for the tracks
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.addTracksToPlaylist = function (
    playlistId,
    uris,
    options,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/playlists/' + playlistId + '/tracks',
      type: 'POST',
      postData: {
        uris: uris
      }
    };
    return _checkParamsAndPerformRequest(requestData, options, callback, true);
  };

  /**
   * Replace the tracks of a playlist
   * See [Replace a Playlist's Tracks](https://developer.spotify.com/web-api/replace-playlists-tracks/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:user:xxxx:playlist:<here_is_the_playlist_id>)
   * @param {Array<string>} uris An array of Spotify URIs for the tracks
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.replaceTracksInPlaylist = function (
    playlistId,
    uris,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/playlists/' + playlistId + '/tracks',
      type: 'PUT',
      postData: { uris: uris }
    };
    return _checkParamsAndPerformRequest(requestData, {}, callback);
  };

  /**
   * Reorder tracks in a playlist
   * See [Reorder a Playlist’s Tracks](https://developer.spotify.com/web-api/reorder-playlists-tracks/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:user:xxxx:playlist:<here_is_the_playlist_id>)
   * @param {number} rangeStart The position of the first track to be reordered.
   * @param {number} insertBefore The position where the tracks should be inserted. To reorder the tracks to
   * the end of the playlist, simply set insert_before to the position after the last track.
   * @param {Object} options An object with optional parameters (range_length, snapshot_id)
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.reorderTracksInPlaylist = function (
    playlistId,
    rangeStart,
    insertBefore,
    options,
    callback
  ) {
    /* eslint-disable camelcase */
    var requestData = {
      url: _baseUri + '/playlists/' + playlistId + '/tracks',
      type: 'PUT',
      postData: {
        range_start: rangeStart,
        insert_before: insertBefore
      }
    };
    /* eslint-enable camelcase */
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Remove tracks from a playlist
   * See [Remove Tracks from a Playlist](https://developer.spotify.com/web-api/remove-tracks-playlist/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:user:xxxx:playlist:<here_is_the_playlist_id>)
   * @param {Array<Object>} uris An array of tracks to be removed. Each element of the array can be either a
   * string, in which case it is treated as a URI, or an object containing the properties `uri` (which is a
   * string) and `positions` (which is an array of integers).
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.removeTracksFromPlaylist = function (
    playlistId,
    uris,
    callback
  ) {
    var dataToBeSent = uris.map(function (uri) {
      if (typeof uri === 'string') {
        return { uri: uri };
      } else {
        return uri;
      }
    });

    var requestData = {
      url: _baseUri + '/playlists/' + playlistId + '/tracks',
      type: 'DELETE',
      postData: { tracks: dataToBeSent }
    };
    return _checkParamsAndPerformRequest(requestData, {}, callback);
  };

  /**
   * Remove tracks from a playlist, specifying a snapshot id.
   * See [Remove Tracks from a Playlist](https://developer.spotify.com/web-api/remove-tracks-playlist/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:user:xxxx:playlist:<here_is_the_playlist_id>)
   * @param {Array<Object>} uris An array of tracks to be removed. Each element of the array can be either a
   * string, in which case it is treated as a URI, or an object containing the properties `uri` (which is a
   * string) and `positions` (which is an array of integers).
   * @param {string} snapshotId The playlist's snapshot ID against which you want to make the changes
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.removeTracksFromPlaylistWithSnapshotId = function (
    playlistId,
    uris,
    snapshotId,
    callback
  ) {
    var dataToBeSent = uris.map(function (uri) {
      if (typeof uri === 'string') {
        return { uri: uri };
      } else {
        return uri;
      }
    });
    /* eslint-disable camelcase */
    var requestData = {
      url: _baseUri + '/playlists/' + playlistId + '/tracks',
      type: 'DELETE',
      postData: {
        tracks: dataToBeSent,
        snapshot_id: snapshotId
      }
    };
    /* eslint-enable camelcase */
    return _checkParamsAndPerformRequest(requestData, {}, callback);
  };

  /**
   * Remove tracks from a playlist, specifying the positions of the tracks to be removed.
   * See [Remove Tracks from a Playlist](https://developer.spotify.com/web-api/remove-tracks-playlist/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:user:xxxx:playlist:<here_is_the_playlist_id>)
   * @param {Array<number>} positions array of integers containing the positions of the tracks to remove
   * from the playlist.
   * @param {string} snapshotId The playlist's snapshot ID against which you want to make the changes
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.removeTracksFromPlaylistInPositions = function (
    playlistId,
    positions,
    snapshotId,
    callback
  ) {
    /* eslint-disable camelcase */
    var requestData = {
      url: _baseUri + '/playlists/' + playlistId + '/tracks',
      type: 'DELETE',
      postData: {
        positions: positions,
        snapshot_id: snapshotId
      }
    };
    /* eslint-enable camelcase */
    return _checkParamsAndPerformRequest(requestData, {}, callback);
  };

  /**
   * Upload a custom playlist cover image.
   * See [Upload A Custom Playlist Cover Image](https://developer.spotify.com/web-api/upload-a-custom-playlist-cover-image/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} playlistId The id of the playlist. If you know the Spotify URI it is easy
   * to find the playlist id (e.g. spotify:user:xxxx:playlist:<here_is_the_playlist_id>)
   * @param {string} imageData Base64 encoded JPEG image data, maximum payload size is 256 KB.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.uploadCustomPlaylistCoverImage = function (
    playlistId,
    imageData,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/playlists/' + playlistId + '/images',
      type: 'PUT',
      postData: imageData.replace(/^data:image\/jpeg;base64,/, ''),
      contentType: 'image/jpeg'
    };
    return _checkParamsAndPerformRequest(requestData, {}, callback);
  };

  /**
   * Fetches an album from the Spotify catalog.
   * See [Get an Album](https://developer.spotify.com/web-api/get-album/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} albumId The id of the album. If you know the Spotify URI it is easy
   * to find the album id (e.g. spotify:album:<here_is_the_album_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getAlbum = function (albumId, options, callback) {
    var requestData = {
      url: _baseUri + '/albums/' + albumId
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches the tracks of an album from the Spotify catalog.
   * See [Get an Album's Tracks](https://developer.spotify.com/web-api/get-albums-tracks/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} albumId The id of the album. If you know the Spotify URI it is easy
   * to find the album id (e.g. spotify:album:<here_is_the_album_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getAlbumTracks = function (albumId, options, callback) {
    var requestData = {
      url: _baseUri + '/albums/' + albumId + '/tracks'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches multiple albums from the Spotify catalog.
   * See [Get Several Albums](https://developer.spotify.com/web-api/get-several-albums/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} albumIds The ids of the albums. If you know their Spotify URI it is easy
   * to find their album id (e.g. spotify:album:<here_is_the_album_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getAlbums = function (albumIds, options, callback) {
    var requestData = {
      url: _baseUri + '/albums/',
      params: { ids: albumIds.join(',') }
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches a track from the Spotify catalog.
   * See [Get a Track](https://developer.spotify.com/web-api/get-track/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} trackId The id of the track. If you know the Spotify URI it is easy
   * to find the track id (e.g. spotify:track:<here_is_the_track_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getTrack = function (trackId, options, callback) {
    var requestData = {};
    requestData.url = _baseUri + '/tracks/' + trackId;
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches multiple tracks from the Spotify catalog.
   * See [Get Several Tracks](https://developer.spotify.com/web-api/get-several-tracks/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} trackIds The ids of the tracks. If you know their Spotify URI it is easy
   * to find their track id (e.g. spotify:track:<here_is_the_track_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getTracks = function (trackIds, options, callback) {
    var requestData = {
      url: _baseUri + '/tracks/',
      params: { ids: trackIds.join(',') }
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches an artist from the Spotify catalog.
   * See [Get an Artist](https://developer.spotify.com/web-api/get-artist/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} artistId The id of the artist. If you know the Spotify URI it is easy
   * to find the artist id (e.g. spotify:artist:<here_is_the_artist_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getArtist = function (artistId, options, callback) {
    var requestData = {
      url: _baseUri + '/artists/' + artistId
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches multiple artists from the Spotify catalog.
   * See [Get Several Artists](https://developer.spotify.com/web-api/get-several-artists/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} artistIds The ids of the artists. If you know their Spotify URI it is easy
   * to find their artist id (e.g. spotify:artist:<here_is_the_artist_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getArtists = function (artistIds, options, callback) {
    var requestData = {
      url: _baseUri + '/artists/',
      params: { ids: artistIds.join(',') }
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches the albums of an artist from the Spotify catalog.
   * See [Get an Artist's Albums](https://developer.spotify.com/web-api/get-artists-albums/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} artistId The id of the artist. If you know the Spotify URI it is easy
   * to find the artist id (e.g. spotify:artist:<here_is_the_artist_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getArtistAlbums = function (artistId, options, callback) {
    var requestData = {
      url: _baseUri + '/artists/' + artistId + '/albums'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches a list of top tracks of an artist from the Spotify catalog, for a specific country.
   * See [Get an Artist's Top Tracks](https://developer.spotify.com/web-api/get-artists-top-tracks/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} artistId The id of the artist. If you know the Spotify URI it is easy
   * to find the artist id (e.g. spotify:artist:<here_is_the_artist_id>)
   * @param {string} countryId The id of the country (e.g. ES for Spain or US for United States)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getArtistTopTracks = function (
    artistId,
    countryId,
    options,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/artists/' + artistId + '/top-tracks',
      params: { country: countryId }
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches a list of artists related with a given one from the Spotify catalog.
   * See [Get an Artist's Related Artists](https://developer.spotify.com/web-api/get-related-artists/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} artistId The id of the artist. If you know the Spotify URI it is easy
   * to find the artist id (e.g. spotify:artist:<here_is_the_artist_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getArtistRelatedArtists = function (
    artistId,
    options,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/artists/' + artistId + '/related-artists'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches a list of Spotify featured playlists (shown, for example, on a Spotify player's "Browse" tab).
   * See [Get a List of Featured Playlists](https://developer.spotify.com/web-api/get-list-featured-playlists/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getFeaturedPlaylists = function (options, callback) {
    var requestData = {
      url: _baseUri + '/browse/featured-playlists'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches a list of new album releases featured in Spotify (shown, for example, on a Spotify player's "Browse" tab).
   * See [Get a List of New Releases](https://developer.spotify.com/web-api/get-list-new-releases/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getNewReleases = function (options, callback) {
    var requestData = {
      url: _baseUri + '/browse/new-releases'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Get a list of categories used to tag items in Spotify (on, for example, the Spotify player's "Browse" tab).
   * See [Get a List of Categories](https://developer.spotify.com/web-api/get-list-categories/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getCategories = function (options, callback) {
    var requestData = {
      url: _baseUri + '/browse/categories'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Get a single category used to tag items in Spotify (on, for example, the Spotify player's "Browse" tab).
   * See [Get a Category](https://developer.spotify.com/web-api/get-category/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} categoryId The id of the category. These can be found with the getCategories function
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getCategory = function (categoryId, options, callback) {
    var requestData = {
      url: _baseUri + '/browse/categories/' + categoryId
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Get a list of Spotify playlists tagged with a particular category.
   * See [Get a Category's Playlists](https://developer.spotify.com/web-api/get-categorys-playlists/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} categoryId The id of the category. These can be found with the getCategories function
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getCategoryPlaylists = function (
    categoryId,
    options,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/browse/categories/' + categoryId + '/playlists'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Get Spotify catalog information about artists, albums, tracks or playlists that match a keyword string.
   * See [Search for an Item](https://developer.spotify.com/web-api/search-item/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} query The search query
   * @param {Array<string>} types An array of item types to search across.
   * Valid types are: 'album', 'artist', 'playlist', and 'track'.
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.search = function (query, types, options, callback) {
    var requestData = {
      url: _baseUri + '/search/',
      params: {
        q: query,
        type: types.join(',')
      }
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches albums from the Spotify catalog according to a query.
   * See [Search for an Item](https://developer.spotify.com/web-api/search-item/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} query The search query
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.searchAlbums = function (query, options, callback) {
    return this.search(query, ['album'], options, callback);
  };

  /**
   * Fetches artists from the Spotify catalog according to a query.
   * See [Search for an Item](https://developer.spotify.com/web-api/search-item/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} query The search query
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.searchArtists = function (query, options, callback) {
    return this.search(query, ['artist'], options, callback);
  };

  /**
   * Fetches tracks from the Spotify catalog according to a query.
   * See [Search for an Item](https://developer.spotify.com/web-api/search-item/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} query The search query
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.searchTracks = function (query, options, callback) {
    return this.search(query, ['track'], options, callback);
  };

  /**
   * Fetches playlists from the Spotify catalog according to a query.
   * See [Search for an Item](https://developer.spotify.com/web-api/search-item/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} query The search query
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.searchPlaylists = function (query, options, callback) {
    return this.search(query, ['playlist'], options, callback);
  };

  /**
   * Fetches shows from the Spotify catalog according to a query.
   * See [Search for an Item](https://developer.spotify.com/web-api/search-item/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} query The search query
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.searchShows = function (query, options, callback) {
    return this.search(query, ['show'], options, callback);
  };

  /**
   * Fetches episodes from the Spotify catalog according to a query.
   * See [Search for an Item](https://developer.spotify.com/web-api/search-item/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} query The search query
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.searchEpisodes = function (query, options, callback) {
    return this.search(query, ['episode'], options, callback);
  };

  /**
   * Get audio features for a single track identified by its unique Spotify ID.
   * See [Get Audio Features for a Track](https://developer.spotify.com/web-api/get-audio-features/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} trackId The id of the track. If you know the Spotify URI it is easy
   * to find the track id (e.g. spotify:track:<here_is_the_track_id>)
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getAudioFeaturesForTrack = function (trackId, callback) {
    var requestData = {};
    requestData.url = _baseUri + '/audio-features/' + trackId;
    return _checkParamsAndPerformRequest(requestData, {}, callback);
  };

  /**
   * Get audio features for multiple tracks based on their Spotify IDs.
   * See [Get Audio Features for Several Tracks](https://developer.spotify.com/web-api/get-several-audio-features/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} trackIds The ids of the tracks. If you know their Spotify URI it is easy
   * to find their track id (e.g. spotify:track:<here_is_the_track_id>)
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getAudioFeaturesForTracks = function (trackIds, callback) {
    var requestData = {
      url: _baseUri + '/audio-features',
      params: { ids: trackIds }
    };
    return _checkParamsAndPerformRequest(requestData, {}, callback);
  };

  /**
   * Get audio analysis for a single track identified by its unique Spotify ID.
   * See [Get Audio Analysis for a Track](https://developer.spotify.com/web-api/get-audio-analysis/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} trackId The id of the track. If you know the Spotify URI it is easy
   * to find the track id (e.g. spotify:track:<here_is_the_track_id>)
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getAudioAnalysisForTrack = function (trackId, callback) {
    var requestData = {};
    requestData.url = _baseUri + '/audio-analysis/' + trackId;
    return _checkParamsAndPerformRequest(requestData, {}, callback);
  };

  /**
   * Create a playlist-style listening experience based on seed artists, tracks and genres.
   * See [Get Recommendations Based on Seeds](https://developer.spotify.com/web-api/get-recommendations/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getRecommendations = function (options, callback) {
    var requestData = {
      url: _baseUri + '/recommendations'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Retrieve a list of available genres seed parameter values for recommendations.
   * See [Available Genre Seeds](https://developer.spotify.com/web-api/get-recommendations/#available-genre-seeds) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getAvailableGenreSeeds = function (callback) {
    var requestData = {
      url: _baseUri + '/recommendations/available-genre-seeds'
    };
    return _checkParamsAndPerformRequest(requestData, {}, callback);
  };

  /**
   * Get information about a user’s available devices.
   * See [Get a User’s Available Devices](https://developer.spotify.com/web-api/get-a-users-available-devices/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getMyDevices = function (callback) {
    var requestData = {
      url: _baseUri + '/me/player/devices'
    };
    return _checkParamsAndPerformRequest(requestData, {}, callback);
  };

  /**
   * Get information about the user’s current playback state, including track, track progress, and active device.
   * See [Get Information About The User’s Current Playback](https://developer.spotify.com/web-api/get-information-about-the-users-current-playback/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getMyCurrentPlaybackState = function (options, callback) {
    var requestData = {
      url: _baseUri + '/me/player'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Get the object currently being played on the user’s Spotify account.
   * See [Get the User’s Currently Playing Track](https://developer.spotify.com/web-api/get-the-users-currently-playing-track/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getMyCurrentPlayingTrack = function (options, callback) {
    var requestData = {
      url: _baseUri + '/me/player/currently-playing'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Transfer playback to a new device and determine if it should start playing.
   * See [Transfer a User’s Playback](https://developer.spotify.com/web-api/transfer-a-users-playback/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} deviceIds A JSON array containing the ID of the device on which playback should be started/transferred.
   * @param {Object} options A JSON object with options that can be passed.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.transferMyPlayback = function (
    deviceIds,
    options,
    callback
  ) {
    var postData = options || {};
    postData.device_ids = deviceIds;
    var requestData = {
      type: 'PUT',
      url: _baseUri + '/me/player',
      postData: postData
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Play a track on the user's active device
   * See [Start/Resume a User's Playback](https://developer.spotify.com/documentation/web-api/reference/player/start-a-users-playback/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.play = function (options, callback) {
    options = options || {};
    var params =
      'device_id' in options ? { device_id: options.device_id } : null;
    var postData = {};
    ['context_uri', 'uris', 'offset', 'position_ms'].forEach(function (field) {
      if (field in options) {
        postData[field] = options[field];
      }
    });
    var requestData = {
      type: 'PUT',
      url: _baseUri + '/me/player/play',
      params: params,
      postData: postData
    };

    // need to clear options so it doesn't add all of them to the query params
    var newOptions = typeof options === 'function' ? options : {};
    return _checkParamsAndPerformRequest(requestData, newOptions, callback);
  };

  /**
   * Add an item to the end of the user’s current playback queue.
   * See [Add an Item to the User's Playback Queue](https://developer.spotify.com/documentation/web-api/reference/player/add-to-queue/) on
   * the Spotify Developer site for more information about the endpoint.
   * @param {string} uri The uri of the item to add to the queue. Must be a track or an episode uri.
   * @param {Object} options A JSON object with options that can be passed.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.queue = function (uri, options, callback) {
    options = options || {};
    var params =
      'device_id' in options
        ? { uri: uri, device_id: options.device_id }
        : { uri: uri };
    var requestData = {
      type: 'POST',
      url: _baseUri + '/me/player/queue',
      params: params
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Pause playback on the user’s account.
   * See [Pause a User’s Playback](https://developer.spotify.com/web-api/pause-a-users-playback/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.pause = function (options, callback) {
    options = options || {};
    var params =
      'device_id' in options ? { device_id: options.device_id } : null;
    var requestData = {
      type: 'PUT',
      url: _baseUri + '/me/player/pause',
      params: params
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Skips to next track in the user’s queue.
   * See [Skip User’s Playback To Next Track](https://developer.spotify.com/web-api/skip-users-playback-to-next-track/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.skipToNext = function (options, callback) {
    options = options || {};
    var params =
      'device_id' in options ? { device_id: options.device_id } : null;
    var requestData = {
      type: 'POST',
      url: _baseUri + '/me/player/next',
      params: params
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Skips to previous track in the user’s queue.
   * Note that this will ALWAYS skip to the previous track, regardless of the current track’s progress.
   * Returning to the start of the current track should be performed using `.seek()`
   * See [Skip User’s Playback To Previous Track](https://developer.spotify.com/web-api/skip-users-playback-to-next-track/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.skipToPrevious = function (options, callback) {
    options = options || {};
    var params =
      'device_id' in options ? { device_id: options.device_id } : null;
    var requestData = {
      type: 'POST',
      url: _baseUri + '/me/player/previous',
      params: params
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Seeks to the given position in the user’s currently playing track.
   * See [Seek To Position In Currently Playing Track](https://developer.spotify.com/web-api/seek-to-position-in-currently-playing-track/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {number} position_ms The position in milliseconds to seek to. Must be a positive number.
   * @param {Object} options A JSON object with options that can be passed.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.seek = function (position_ms, options, callback) {
    options = options || {};
    var params = {
      position_ms: position_ms
    };
    if ('device_id' in options) {
      params.device_id = options.device_id;
    }
    var requestData = {
      type: 'PUT',
      url: _baseUri + '/me/player/seek',
      params: params
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Set the repeat mode for the user’s playback. Options are repeat-track, repeat-context, and off.
   * See [Set Repeat Mode On User’s Playback](https://developer.spotify.com/web-api/set-repeat-mode-on-users-playback/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {String} state A string set to 'track', 'context' or 'off'.
   * @param {Object} options A JSON object with options that can be passed.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.setRepeat = function (state, options, callback) {
    options = options || {};
    var params = {
      state: state
    };
    if ('device_id' in options) {
      params.device_id = options.device_id;
    }
    var requestData = {
      type: 'PUT',
      url: _baseUri + '/me/player/repeat',
      params: params
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Set the volume for the user’s current playback device.
   * See [Set Volume For User’s Playback](https://developer.spotify.com/web-api/set-volume-for-users-playback/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {number} volume_percent The volume to set. Must be a value from 0 to 100 inclusive.
   * @param {Object} options A JSON object with options that can be passed.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.setVolume = function (volume_percent, options, callback) {
    options = options || {};
    var params = {
      volume_percent: volume_percent
    };
    if ('device_id' in options) {
      params.device_id = options.device_id;
    }
    var requestData = {
      type: 'PUT',
      url: _baseUri + '/me/player/volume',
      params: params
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Toggle shuffle on or off for user’s playback.
   * See [Toggle Shuffle For User’s Playback](https://developer.spotify.com/web-api/toggle-shuffle-for-users-playback/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {bool} state Whether or not to shuffle user's playback.
   * @param {Object} options A JSON object with options that can be passed.
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.setShuffle = function (state, options, callback) {
    options = options || {};
    var params = {
      state: state
    };
    if ('device_id' in options) {
      params.device_id = options.device_id;
    }
    var requestData = {
      type: 'PUT',
      url: _baseUri + '/me/player/shuffle',
      params: params
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches a show from the Spotify catalog.
   * See [Get a Show](https://developer.spotify.com/documentation/web-api/reference/shows/get-a-show/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} showId The id of the show. If you know the Spotify URI it is easy
   * to find the show id (e.g. spotify:show:<here_is_the_show_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getShow = function (showId, options, callback) {
    var requestData = {};
    requestData.url = _baseUri + '/shows/' + showId;
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches multiple shows from the Spotify catalog.
   * See [Get Several Shows](https://developer.spotify.com/documentation/web-api/reference/shows/get-several-shows/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} showIds The ids of the shows. If you know their Spotify URI it is easy
   * to find their show id (e.g. spotify:show:<here_is_the_show_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getShows = function (showIds, options, callback) {
    var requestData = {
      url: _baseUri + '/shows/',
      params: { ids: showIds.join(',') }
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches current user's saved shows.
   * See [Get Current User's Saved Shows](https://developer.spotify.com/documentation/web-api/reference/library/get-users-saved-shows/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getMySavedShows = function (options, callback) {
    var requestData = {
      url: _baseUri + '/me/shows'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Adds a list of shows to the current user's saved shows.
   * See [Save Shows for Current User](https://developer.spotify.com/documentation/web-api/reference/library/save-shows-user/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} showIds The ids of the shows. If you know their Spotify URI it is easy
   * to find their show id (e.g. spotify:show:<here_is_the_show_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.addToMySavedShows = function (showIds, options, callback) {
    var requestData = {
      url: _baseUri + '/me/shows',
      type: 'PUT',
      postData: showIds
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Remove a list of shows from the current user's saved shows.
   * See [Remove Shows for Current User](https://developer.spotify.com/documentation/web-api/reference/library/remove-shows-user/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} showIds The ids of the shows. If you know their Spotify URI it is easy
   * to find their show id (e.g. spotify:show:<here_is_the_show_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.removeFromMySavedShows = function (
    showIds,
    options,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/me/shows',
      type: 'DELETE',
      postData: showIds
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Checks if the current user's saved shows contains a certain list of shows.
   * See [Check Current User's Saved Shows](https://developer.spotify.com/documentation/web-api/reference/library/check-users-saved-shows/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} showIds The ids of the shows. If you know their Spotify URI it is easy
   * to find their show id (e.g. spotify:show:<here_is_the_show_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.containsMySavedShows = function (
    showIds,
    options,
    callback
  ) {
    var requestData = {
      url: _baseUri + '/me/shows/contains',
      params: { ids: showIds.join(',') }
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches the episodes of a show from the Spotify catalog.
   * See [Get a Show's Episodes](https://developer.spotify.com/documentation/web-api/reference/shows/get-shows-episodes/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} showId The id of the show. If you know the Spotify URI it is easy
   * to find the show id (e.g. spotify:show:<here_is_the_show_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getShowEpisodes = function (showId, options, callback) {
    var requestData = {
      url: _baseUri + '/shows/' + showId + '/episodes'
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches an episode from the Spotify catalog.
   * See [Get an Episode](https://developer.spotify.com/documentation/web-api/reference/episodes/get-an-episode/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {string} episodeId The id of the episode. If you know the Spotify URI it is easy
   * to find the episode id (e.g. spotify:episode:<here_is_the_episode_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getEpisode = function (episodeId, options, callback) {
    var requestData = {};
    requestData.url = _baseUri + '/episodes/' + episodeId;
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Fetches multiple episodes from the Spotify catalog.
   * See [Get Several Episodes](https://developer.spotify.com/documentation/web-api/reference/episodes/get-several-episodes/) on
   * the Spotify Developer site for more information about the endpoint.
   *
   * @param {Array<string>} episodeIds The ids of the episodes. If you know their Spotify URI it is easy
   * to find their episode id (e.g. spotify:episode:<here_is_the_episode_id>)
   * @param {Object} options A JSON object with options that can be passed
   * @param {function(Object,Object)} callback An optional callback that receives 2 parameters. The first
   * one is the error object (null if no error), and the second is the value if the request succeeded.
   * @return {Object} Null if a callback is provided, a `Promise` object otherwise
   */
  Constr.prototype.getEpisodes = function (episodeIds, options, callback) {
    var requestData = {
      url: _baseUri + '/episodes/',
      params: { ids: episodeIds.join(',') }
    };
    return _checkParamsAndPerformRequest(requestData, options, callback);
  };

  /**
   * Gets the access token in use.
   *
   * @return {string} accessToken The access token
   */
  Constr.prototype.getAccessToken = function () {
    return _accessToken;
  };

  /**
   * Sets the access token to be used.
   * See [the Authorization Guide](https://developer.spotify.com/web-api/authorization-guide/) on
   * the Spotify Developer site for more information about obtaining an access token.
   *
   * @param {string} accessToken The access token
   * @return {void}
   */
  Constr.prototype.setAccessToken = function (accessToken) {
    _accessToken = accessToken;
  };

  /**
   * Sets an implementation of Promises/A+ to be used. E.g. Q, when.
   * See [Conformant Implementations](https://github.com/promises-aplus/promises-spec/blob/master/implementations.md)
   * for a list of some available options
   *
   * @param {Object} PromiseImplementation A Promises/A+ valid implementation
   * @throws {Error} If the implementation being set doesn't conform with Promises/A+
   * @return {void}
   */
  Constr.prototype.setPromiseImplementation = function (PromiseImplementation) {
    var valid = false;
    try {
      var p = new PromiseImplementation(function (resolve) {
        resolve();
      });
      if (typeof p.then === 'function' && typeof p.catch === 'function') {
        valid = true;
      }
    } catch (e) {
      console.error(e);
    }
    if (valid) {
      _promiseImplementation = PromiseImplementation;
    } else {
      throw new Error('Unsupported implementation of Promises/A+');
    }
  };

  return Constr;
})();

if ( true && typeof module.exports === 'object') {
  module.exports = SpotifyWebApi;
}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!*********************************!*\
  !*** ./resources/js/spotify.js ***!
  \*********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

var SpotifyWebApi = __webpack_require__(/*! spotify-web-api-js */ "./node_modules/spotify-web-api-js/src/spotify-web-api.js");

window.onSpotifyWebPlaybackSDKReady = function () {
  var VCSpotify = function () {
    return {
      init: function init() {
        var _this = this;

        this.spotifyAPI = new SpotifyWebApi();
        this.token = null;
        this.prevSearch = null;
        this.playing = true;
        this.currentSong = 'spotify:track:4kzvAGJirpZ9ethvKZdJtg';
        this.player = new Spotify.Player({
          name: 'VibeCity',
          getOAuthToken: function () {
            var _getOAuthToken = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(callback) {
              var response;
              return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
                while (1) {
                  switch (_context.prev = _context.next) {
                    case 0:
                      _context.next = 2;
                      return fetch("/refreshSpotifyToken", {
                        headers: {
                          "Accept": "text/plain",
                          "X-Requested-With": "XMLHttpRequest",
                          "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        method: "get",
                        credentials: "same-origin"
                      });

                    case 2:
                      response = _context.sent;
                      _context.next = 5;
                      return response.text();

                    case 5:
                      _this.token = _context.sent;
                      console.log("Spotify Token: " + _this.token);
                      callback(_this.token);

                    case 8:
                    case "end":
                      return _context.stop();
                  }
                }
              }, _callee);
            }));

            function getOAuthToken(_x) {
              return _getOAuthToken.apply(this, arguments);
            }

            return getOAuthToken;
          }(),
          volume: 1.0
        });
        this.connectPlayer();
        var x = setInterval(function () {
          if (_this.token !== null) {
            clearInterval(x);

            _this.spotifyAPI.setAccessToken(_this.token);

            document.getElementById('loader').style.display = 'none';
          }
        }, 100);
        this.cacheDOM();
        this.bindEvents();
      },
      cacheDOM: function cacheDOM() {
        // this.addSongStartButton = document.getElementById("addSongStart");
        // this.closeSearchButton = document.getElementById("closeSearchButton");
        // this.spotifySearchButton = document.getElementById("spotifySearch");
        this.spotifyPlayPauseButton = document.getElementById("togglePlayPause");
        this.albumArt = document.getElementById("albumArt");
      },
      bindEvents: function bindEvents() {
        var _this2 = this;

        // this.addSongStartButton.addEventListener("click", this.addSongStart.bind(this));
        // this.closeSearchButton.addEventListener("click", this.closeSearchModal.bind(this));
        // this.spotifySearchButton.addEventListener('input', this.spotifySearch.bind(this));
        this.spotifyPlayPauseButton.addEventListener('click', this.togglePlayPause.bind(this));
        this.player.addListener('ready', function (_ref) {
          var device_id = _ref.device_id;
          _this2.device_id = device_id;
          console.log('Device ID: ' + device_id);

          _this2.spotifyAPI.transferMyPlayback([_this2.device_id], {
            play: false
          }).then(function (_) {
            _this2.playSong(_this2.currentSong);
          });
        });
      },
      connectPlayer: function connectPlayer() {
        var iframe = document.querySelector('iframe[src="https://sdk.scdn.co/embedded/index.html"]');

        if (iframe) {
          iframe.style.display = 'block';
          iframe.style.position = 'absolute';
          iframe.style.top = '-1000px';
          iframe.style.left = '-1000px';
        }

        this.player.connect().then(function (success) {
          if (success) {
            console.log('The Web Playback SDK successfully connected to Spotify!');
          }
        });
      },
      getCurrentSong: function getCurrentSong() {},
      getPlaybackInfo: function getPlaybackInfo() {
        var _this3 = this;

        return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
          var info;
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
            while (1) {
              switch (_context2.prev = _context2.next) {
                case 0:
                  _context2.next = 2;
                  return _this3.spotifyAPI.getMyCurrentPlaybackState();

                case 2:
                  info = _context2.sent;
                  return _context2.abrupt("return", info);

                case 4:
                case "end":
                  return _context2.stop();
              }
            }
          }, _callee2);
        }))();
      },
      addSongStart: function addSongStart() {
        console.log('adding song');
        document.getElementById('searchModal').style.display = "block";
      },
      closeSearchModal: function closeSearchModal() {
        document.getElementById('searchModal').style.display = "";
      },
      spotifySearch: function spotifySearch(query) {
        var _this4 = this;

        this.prevSearch = this.spotifyAPI.searchTracks(query, {
          limit: 5
        });
        this.prevSearch.then(function (data) {
          _this4.prevSearch = null;
          console.log(data);
        }, function (err) {
          _this4.prevSearch.abort();

          console.error(err);
        });
      },
      playSong: function playSong(uri) {
        var _arguments = arguments,
            _this5 = this;

        return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
          var position;
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
            while (1) {
              switch (_context3.prev = _context3.next) {
                case 0:
                  position = _arguments.length > 1 && _arguments[1] !== undefined ? _arguments[1] : 0;
                  _context3.next = 3;
                  return _this5.spotifyAPI.play({
                    uris: [uri],
                    position_ms: position
                  }).then(function () {
                    _this5.getPlaybackInfo().then(function (res) {
                      _this5.albumArt.style = "background-image:url('".concat(res.item.album.images[0].url, "')");
                    });
                  });

                case 3:
                case "end":
                  return _context3.stop();
              }
            }
          }, _callee3);
        }))();
      },
      togglePlayPause: function togglePlayPause() {
        var _this6 = this;

        this.player.togglePlay().then(function () {
          console.log('Toggled playback!');

          if (_this6.playing) {
            _this6.spotifyPlayPauseButton.className = "far fa-play-circle fa-3x";
          } else {
            _this6.spotifyPlayPauseButton.className = "far fa-pause-circle fa-3x";
          }

          _this6.playing = !_this6.playing;
        });
      }
    };
  }();

  var spotify = VCSpotify;
  spotify.init();
};
})();

/******/ })()
;