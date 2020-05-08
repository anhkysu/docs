# Thiết kế scalable React App từ đầu

> Ngày nay khi mà MVC dần trở thành một thứ nhà quê "lạc hậu", `APIs được thiết kế chung cho nhiều client app khác nhau (web app, mobile app or desktop app)` và khá nhiều business logic được chuyển đến client app. Front-end development giờ không chỉ đơn thuần là tạo ra giao diện nữa mà là cả một nghệ thuật và bí kíp lập trình 😎.

Một ngày đẹp trời, công ty của bạn quyết định đập bỏ hết, build lại toàn bộ hệ thống để tạo ra một thứ gì đó lớn hơn để theo kịp với business grow của công ty 😏, maintainable & scalable hơn đống sh!t code cũ và cuối cùng quyết định chọn React. Bạn chắc hẳn đã vọc React rất nhiều, chứ nếu không thì đã méo chọn React 😏, tuy vậy vẫn còn khá là nhiều thứ cần quyết định trong front-end stack. React về cơ bản chỉ là một view library và có quá nhiều thứ không đi kèm (nếu không muốn chọn nhiều thì xài framework như Ạngular hoặc Vue cho dễ đi 😏 tuy nhiên độ customable và optimizable thì tất nhiên không bằng rồi). State management, routing, localization, styling và UI, deployment và build script... Có cần PWA (Progressive Web App) hay SSR (Server-side Rendering) không?

Thật không may, có rất nhiều sự tự do cho bạn khi quyết định các thành phần trong React stack. Nếu bạn biết rõ mình đang làm gì (requirements), thậm chỉ có thể setup hết tất cả trong vòng một ngày hoặc ít hơn. Hoặc không thì có thể mất tới một tuần hoặc vài tháng tuần cho tới khi mọi thứ chạy suôn sẻ. Ở bài viết này tui chỉ đề cấp tới việc architecting trong một bối cảnh tương đối lí tưởng, bởi vì nếu không lí tưởng thì có quá nhiều thứ cần phải viết 😂.

> Trước khi bắt đầu, hãy phân tích kĩ và code đơn giản thôi
> `Phân tích requirements và nhu cầu nên là điều đầu tiên bạn cần làm bất cứ khi nào bạn muốn bắt đầu làm một cái mới.` Dù là project nhỏ hay lớn, hãy viết rõ ra các yêu cầu và suy nghĩ trong bối cảnh bạn đang không có nó 😂. Dĩ nhiên, requirements có thể thay đổi thường xuyên, có khi còn thay đổi luôn hướng đi, mục đích của project 😂, tuy nhiên đó là điều trong tương lai và méo ai có thể dự đoán được. Mà tốt nhất là dự đoán ít thôi cho đỡ mệt 😂.
> Để release ổn thoả phiên bản đầu tiên của sản phẩm `(MVP: Minimum Viable Product hay Sản phẩm khả dụng tối thiểu)`, tốt nhất nên code đơn giản thôi, chỉ xài tools và libraries cần thiết, đừng phức tạp hoá quá hoặc làm màu 😂. Developer nào cũng thích thử & xài cái mới, nhưng không phải vào thời điểm này (bắt đầu project) 😂.

> ## Về team và con người

Tui đã setup khá nhiều project rồi, và có một sự thật được rút ra là: `Không có gì nát hơn là bắt đầu project khi để teamate của bạn phải research quá nhiều công nghệ mới` 😂. Hãy tưởng tượng có thêm người join vào project ở thời điểm giữa và người đó phải dành 2-3 tháng research để có thể nhảy vào làm. 😂 Ví dụ điển hình ở đây là áp dụng GraphQL cho project chả hạn 😂 (mặc dù ai cũng biết là nó hầu như tốt hơn REST trong các dự án lớn nhưng mà có mấy ai đã học nó đâu, với học cũng đâu có nhanh 😞, nếu xác định apply mà cả team phải cắm đầu vô research thì... 😏).

Ngoài ra, JavaScript bản thân nó là một ngôn ngữ cực kì sida rồi 😂, `common patterns và best practice rất quan trọng khi code chung trong một project lớn, nếu áp dụng tốt thì code JS của project sẽ dễ đọc dễ hiểu mà dễ maintain hơn, còn nếu không thì chỉ có nước đập đi mà xây lại cái khác` 😥. Lấy ví dụ hãy thử nghĩ về đoạn code JS bạn viết 6 tháng hoặc 1 năm trước mà xem 😂. Vì thế hãy chắc chắn rằng teamate của bạn đã nắm rõ các best practice và các convention (thống nhất) chung khi làm việc trong project, apply eslint một cách nghiệm ngặt & check linter trước rồi mới cho commit xài husky, hoặc hoặc sử dụng `typescript` chẳng hạn, sẽ có ích rất nhiều trong một team lớn đó.

> Chọn library xài cho app, cái nào ngon nhất? 😳
> `Câu trả lời là: library mà bạn và team của bạn biết xài & hiểu nó nhất, nghiêm túc á` 😂. Nếu bạn nắm rõ Redux, thì hãy xài Redux cho State Management. Hoặc nếu bạn và team làm việc với MobX nhiều hơn, xài MobX thôi. Một Stack hay Library chỉ thực sự tốt khi các developers hiểu rõ và biết cách tận dụng nó. Tui không nói là bạn không nên xài mấy cái lib mới. Tui rất thích học xài mấy cái mới, nhưng mà chỉ xài áp dụng trong các dự án cá nhân, các dự án ít quan trọng mà ở đó những sai lầm nhỏ được chấp nhận 😏. Học cách xài library mới không đơn giản chỉ là cắm mặt vào document của nó, đôi khi những lib khác nhau có những cách tiếp cận khác nhau và những pattern khác nhau đòi hỏi thời gian để master 😕.

Ờ thực ra thì, thêm vào một vài lib mới cũng không sao 😏, nhưng hãy `chắc chắn rằng nó sẽ không ảnh hưởng nhiều tới tiến độ và chất lượng của project cũng như làm khổ anh em trong team`. Mặc dù thích hay không thích, bạn cũng sẽ phải nghĩ tới suy nghĩ của các developer khác trong team. "A good developer knows how to code. A great developer knows how to work in a team." 😎 Sẽ tốt hơn nếu team bạn có nhiều điểm chung về technical, nó sẽ khiến tốc độ develop nhanh hơn và thuận lợi hơn (mặc khác sẽ là thảm hoạ nếu để 1 team chuyên code Jquery code chung với team code React mà không có convention kĩ 😂 hẳn là nát thôi rồi). Những công nghệ phổ biến (phổ biến chứ không phải quá cũ kĩ hay bị outdated!) có thể tăng tốc độ develop lên nhiều khi team scale về mặt con người.

Lựa chọn của tui khi chọn Libraries
Ở các dự án có business lớn, quan trọng và cần độ ổn định cao, tui không thích xài những cái đang trong giai đoạn "beta" hoặc "experiment" (ngồi chờ issue được approve pull request 😒). Thay vào đó `quality, reliability và scalability` mới là những cái ưu tiên hàng đầu mà bạn cần tập trung vô 😏. Dưới đây là một vài cái mà tui đã chọn.

## quality / reliability /scalability

## Dev stack và Toolkits

`Setup project React ngay từ đầu với` **Webpack và Babel** `khá hay và thú vị`, ngầu nữa nhưng để dễ dàng hơn, tui sẽ dùng create-react-app script trước để design các phần chính của project, sau đó eject và mount lại với webpack và babel có vẻ sẽ ổn hơn. Create-react-app phiên bản v2 gần đây thực sự ổn (hơn nhiều so với v1), hỗ trợ hầu hết các tính năng mà app vừa và nhỏ cần, tuy nhiên nó có vẻ vẫn chưa integrate với server-side rendering và để chunking code tốt hơn, tự cấu hình webpack & babel vậy 😂 (ngoài ra webpack tui có thể chủ động config alias hoặc làm việc với env file rất sướng). Về phần SSR, có thể viết bằng ngôn ngữ nào cũng được (Java, Go hay .NET cũng được nhé 😂), nhưng ở đây tui chọn Node.js và Express cho dễ, ngoài ra có phần get API trên SSR để SEO, tui xài react-frontload và fetch. Về phần React Dev thì xài webpack-dev-server với Hot Reload Module, Redux Dev Tool, Redux-Logger có vẻ ổn.

Ngoài ra, requirement từ đầu là xây lại một app scalable, có SSR, PWA và build script riêng, tích hợp vào Docker nữa, thôi eject ra cho chắc vậy 😏. Tuy vậy nhưng thú thật là phần config webpack, babel đến giờ vẫn khá là painful 😂.

> ## Chốt: Webpack, React-Loadable, Babel, ReactDOM Server và Node.js Express cho Server-side Rendering

## UI Library

Đây là phần khó chọn nhất khi có hàng tấn UI Library ngoài kia 😂, như là Material-UI hoặc Ant Design. Có một lưu ý nhỏ là các bạn nên tìm chọn những UI Library được build chuẩn cho React, ngày xưa tui có vô tình được code trong một project React xài MaterializeCSS, lib này xài chung với JQuery để thao tác với dom thật nên rất dễ gây xung đột với DOM ảo của React, theo tui là không nên xài 😂.

Bootstrap 4 cũng đã có mặt trên UI Library: Reactstrap, tui rất thích Bootstrap nhưng do đã xài reactstrap này trước đó và thấy nó khá là sida, build chưa tốt lắm, nên chắc cần thêm thời gian để đợi thằng bootstrap lên bản 4 vậy. Cuối cùng quyết định chọn AntDesign vì thấy xài thử nó khá ngon (tuy là của Trung Quốc), ngôn ngữ thiết kế khá oke, có rất nhiều component sẵn và hỗ trợ API đến tận răng, ngoài ra document của nó cũng khá chi tiết và đàng hoàng, duyệt thôi 😍. Note: Sau khi xài và optimize thì thấy bộ icon bằng svg của nó hơi nặng khi import vô hết, làm cho kích cỡ file bundle.js tăng lên đáng kể 😂, nhưng không sao, ta có thể custom bundle với webpack mà 😏, mà thôi chuyện đó để sau.

> ## Chốt: Ant Design

Ant Design

## State management

Đơn giản rồi, chọn Redux thôi, vì trước giờ chỉ làm nhiều với thằng này 😂. Kiến trúc và cách tiếp cận của Redux cũng khá đơn giản, ngoài ra Redux còn được xây dựng để code tốt với functional programming, rất rõ ràng và dễ hiểu. Ngoài Redux ra thì còn một vài lựa chọn khác ít phổ biến như Flux (do Facebook phát triển, Redux lấy kiến trúc từ Flux, nhưng dễ xài hơn), hoặc MobX (ít phổ biến hơn Redux).

Một khi bạn đã làm chủ được kiến trúc của redux, có thể thoải mái lựa chọn các lib đi kèm theo. Ở đây tui chọn redux-thunk, reselect, redux-form (để quản lí state của form dễ dàng, thực ra Ant Design có sẵn rồi nhưng phòng trường hợp những form custom riêng thì xài); redux-saga cũng khá tốt, tuy nhiên nó hơi phức tạp quá và document API cũng nhiều, chưa nhiều dev có kinh nghiệm làm với nó nên thôi.

> ## Chốt: Redux, Reselect, Redux Thunk (middleware), Redux Form, Redux Logging (middeware), Redux DevTool

Gợi ý đọc: Redux from a functional programming perspective

## Localization

Để setup đa ngôn ngữ cho app tui xài redux-i18n luôn, tích hợp sẵn vào redux và cũng khá dễ để xài + có vài project trước xài nó rồi. Ngoài ra có một lib khác phổ biến hơn là react-i18next cũng khá dễ xài.

> ## Chốt: Redux-i18n

## Routing

Về phần routing, react-router là một sự lựa chọn phổ biến và dùng tốt trong hầu hết các project. Tuy concept của sẽ hơi khó hiểu một tí so với các bộ routing khác của Angular hay Vue. Chú ý nếu muốn tối ưu hoá, chunking code theo từng Route (xài với React-Loadble) thì nên viết kĩ phần Routing.

> ## Chốt: React-Router

## Linter, Convention, Structure

Define convention và Linter là một bước khá quan trọng trong xây dựng code base, để đáp ứng develop ổn định và tính maintainable. Về Linter, tui xài eslint với một số bộ config sẵn lấy từ airbnb, custom thêm một số phần. Về phần lint check, tui xài husky và lintstaged cũng như prettier để kiểm tra lint code, và chặn commit, push code khi chưa Lint-valid. Tất cả sẽ work ngon lành nếu bạn xài VSCode và một số extension cài sẵn.

Về Project Organization, có khá nhiều cách triển khai phù hợp với Business của app và sở thích của từng team, tui quyết định chọn implement theo Feature Based vì khá dễ scale cũng như dễ code ở một project lớn nhiều component. Bạn có thể xem thêm về cách triển khai này ở đây: https://medium.com/@alexmngn/how-to-better-organize-your-react-applications-2fd3ea1920f1.

Phần API/service caller, tui chọn implement ở một repo code base riêng, tạm gọi API SDK, viết bằng TypeScript, để scale thì nên tách Caller ra riêng để có thể apply ở nhiều repos sau này mà không bị lặp code cũng như đảm bảo tính đóng gói. Chốt: viết ra repo lib riêng và xài axios cho phần caller.

## Ngoài ra với Unit Test, tui chọn **Jest và Enzyme** vì nó khá phổ biến để testing React app.

## Về phần containerize và dockerize

Cần implement 1 Dockerfile là chạy ổn, có thêm SSR nên sẽ hơi phức tạp tí, build bằng yarn (nhờ chạy parallel và cache) hoặc npm ci (lưu cache sẵn vào git repo -> phù hợp với use case build docker image của tui) có vẻ sẽ nhanh hơn npm; đọc thêm về npm ci vs npm install ở đây, cũng tích hợp khá ổn với Jenkins CI/CD (có thể xem file ở dưới phần P/S nhá). Khi cần chơi lớn, có thể dễ dàng triển khai theo dạng container lên Kubernetes Cluster (xài Google Kubernetes Engine chả hạn), bạn sẽ có 1 con load balancer (Nginx Ingress) và muốn tạo bao nhiêu instance cũng được 😏.

Đọc thêm: Deploying a containerized web application by Google Kubernetes Engine

Vậy đã scalable chưa? 😂
Scale theo hướng nào còn tuỳ thuộc vào business của mỗi project, và phải do bạn tự quyết định 😏. Theo ý kiến cá nhân của tui, để scale nên structure và organization source code theo suy nghĩ mở rộng ra (featured based chả hạn), đặt các helper và utils ở nơi phù hợp (để import và reuse nhiều chỗ), không code lặp, wrap các function được gọi nhiều và viết các components để tái sử dụng, áp dụng Higher-Order Function cho các hàm wrap, giải quyết vấn đề xung đột CSS (CSS War) giữa các components bằng styled-components chả hạn. Code-base dễ đọc dễ hiểu, clean, tính customable cao -> dễ đáp ứng requirement changes, có bộ convention và documenting rõ ràng... vân vân và mây mây.

Feature Based:

|-- project-name
| |-- src
| | +-- common
| | |-- features
| | | |-- home
| | | | +-- redux
| | | | |-- index.js
| | | | |-- DefaultPage.js
| | | | |-- DefaultPage.less
| | | | |-- route.js
| | | | |-- styles.less
| | | | |-- ...
| | | +-- feature-1
| | | +-- feature-2
| | +-- styles
| --- tools
| | +-- plugins
| --- scripts
| | |-- build.js
| | |-- start.js
| | |-- ...
|-- .eslintrc
|-- .gitignore
|-- ...

Đọc thêm về 4 cách để thiết kế CSS Style cho React Component.

Đọc bài về scale ở blog của huydx. Rút ra được kết luận: Để làm một hệ thống “scale”, bạn chỉ cần làm 4 bước: đoán mò -> kiểm thử -> cải thiện -> đoán mò tiếp, và tui vẫn chỉ đang lẩn quần trong vòng lặp này 😂. 2 công cụ benchmark (kiểm thử) hay dùng là Google Pagespeed và Lighthouse.

Tổng kết
Sẽ ổn thôi nếu bạn vẫn xài những lib phổ biến (không phải latest) hoặc làm theo những best pracice và patterns có sẵn. Chúng ta không cần phải chọn những library thật sự mới mẻ, bởi vì: "business always comes first", và vì như vậy nên ta cần những thứ reliable và tốt cho team hơn, thứ sẽ giúp mọi thứ đi đúng hướng và nhanh hơn.

Một vài yếu tố quan trọng nữa là dùng những lib có cộng đồng lớn và hỗ trợ lâu dài sẽ tốt cho quá trình develop hơn, bạn sẽ nhận được support của các developers khác trên khắp thế giới thông qua stackoverflow và github pages, issues cũng có thể được fix và merge rất nhanh từ các contributors.