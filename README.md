# Atlas DB System

**Atlas** is a multithreaded asynchronous MySQL query system built for PocketMine-MP. It provides a clean, non-blocking API using fibers and a thread-safe queuing model for executing MySQL queries in worker threads with callback support.

> ⚡ Designed for performance-critical Bedrock servers like [Pixals], Designed By the Innovation Wing of Pixals..

---

## 🚀 Features

- ✅ **True Multithreading**: Uses `pmmpthreads` to offload queries from the main thread.
- ✅ **Fiber-compatible Await API**: Works seamlessly with `Await::f2c()` for async-style flow [Still under Development].
- ✅ **ThreadSafe Query Model**: AtlasQuery is a fully serializable, thread-safe unit of work.
- ✅ **Result Propagation**: Queries return results back to the main thread using safe bridges [Still under Development].
- ✅ **No Blocking, No Lag**: Queries are handled in background workers, keeping tick performance smooth.

---

## 📦 Installation

Will be Released After the Finish of Development.
