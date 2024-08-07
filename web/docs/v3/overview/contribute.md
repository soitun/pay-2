# 参与开发

由于测试及使用环境的限制，本项目中只开发了「支付宝」、「微信支付」、「抖音支付」、「银联」、「江苏银行」的相关支付网关。

如果您有其它支付网关的需求，或者发现本项目中需要改进的代码，**_欢迎 Fork 并提交 PR！_**

参与开发前，请先仔细阅读 [核心架构](/docs/v3/kernel/kernel.md) 以便了解相关核心思想。

这里说下阅读代码或者插件开发过程中可能的一些疑问：

## 插件的部分冗余性

插件根据场景都独立出，造成有些相同 API 又基本复制了一份，有好处，有坏处。

### 好处

- API 插件之间互不影响，修改某个插件不会影响其它插件的使用
- 一个插件就是一个 API，各个插件使用起来无心智负担，只用关注自己的插件即可

### 坏处

- 代码有部分冗余

从以上的思考，我们可以得出一个结论：**_对于相同 API 插件的部分冗余性，带给我们的收益是值得的_**
