### 1. Tổng hợp thông tin cốt lõi của dự án

Dự án nhằm xây dựng một hệ thống tạo lập, duy trì và cập nhật biểu diễn số có cấu trúc về trạng thái năng lực của cá nhân tại từng thời điểm (Bản sao số năng lực).

* **Nguyên tắc vận hành:** Lấy cá nhân làm chủ thể trung tâm; đánh giá phải dựa trên minh chứng truy xuất được nguồn gốc; AI chỉ đóng vai trò hỗ trợ và không tự động ra quyết định; bảo vệ dữ liệu được thiết kế ngay từ đầu (Privacy by design).


* **Kiến trúc khung năng lực (TCF):** Sử dụng thiết kế 3 lớp linh hoạt gồm: Lớp nền tảng (24 năng lực chung dùng cho mọi ngành), Lớp chuyên ngành (do chuyên gia xây dựng) và Lớp hồ sơ vị trí (cấu hình riêng cho từng doanh nghiệp).


* **Lõi công nghệ đột phá (Sáng chế):** Hệ thống không ghi đè dữ liệu lịch sử. Khi có minh chứng mới, hệ thống duyệt một "cấu trúc quan hệ phụ thuộc" (đồ thị) để tìm chính xác các nút trạng thái bị ảnh hưởng, tính toán lại cục bộ và sinh ra một bản ghi phiên bản mới (T1, T2... Tn) với dấu vân tay dữ liệu (hash) riêng biệt.


* **Trạng thái dữ liệu:** Áp dụng thang đo 6 mức (M1 đến M5), trong đó có trạng thái "Chưa đủ dữ liệu" được phân tách rõ ràng với mức năng lực, đồng thời phân biệt rạch ròi giữa "Mức năng lực" và "Mức độ tin cậy" của minh chứng.



---

### 2. Roadmap triển khai hệ thống

Lộ trình được lồng ghép giữa tiến độ phát triển phần mềm (MVP) và kế hoạch thử nghiệm thực tế 18 tháng tại địa bàn (với quy mô 100-200 hồ sơ, 5-10 vị trí).

**Giai đoạn 1: Khảo sát, Thiết kế & Sprint 0 (Tháng 1 - Tháng 3)**

* Khảo sát địa bàn, chốt danh sách tổ chức và vị trí việc làm tham gia.


* Khóa user journey, ma trận phân quyền, phân loại dữ liệu, xây dựng wireframe và mô hình dữ liệu (ERD).


* Đầu ra: Tài liệu SRS v1, cấu trúc khung năng lực mẫu, kế hoạch nghiệm thu.



**Giai đoạn 2: Phát triển MVP Core (Tháng 4 - Tháng 6)**

* Lập trình các module lõi: Quản lý tài khoản (IAM), Quản lý phiên bản khung năng lực, Quản lý hồ sơ và Quy trình duyệt minh chứng.


* Xây dựng thuật toán tạo trạng thái năng lực ban đầu (T0).


* Đầu ra: Bản nguyên mẫu (prototype) chạy trên môi trường test với dữ liệu giả lập, tài liệu quản trị dữ liệu.



**Giai đoạn 3: Thử nghiệm vòng 1 - Thiết lập T0 (Tháng 7 - Tháng 10)**

* Đưa người dùng thực vào hệ thống (onboarding), thu thập minh chứng và thực hiện đánh giá đa nguồn.


* Hệ thống chạy các luồng AI cơ bản (AI-01 OCR, AI-02 gợi ý ánh xạ).


* Đầu ra: Hình thành được trạng thái T0 (hoặc kết quả chưa đủ dữ liệu) cho các hồ sơ, xuất báo cáo phân tích khoảng cách năng lực.



**Giai đoạn 4: Can thiệp phát triển & Thử nghiệm vòng 2 (Tháng 11 - Tháng 17)**

* Lập kế hoạch phát triển (đào tạo, thực hành) dựa trên khoảng cách năng lực đã phân tích.


* Bổ sung minh chứng mới vào hệ thống sau quá trình đào tạo để hệ thống kích hoạt tính toán lại, tạo ra phiên bản trạng thái cập nhật (T1, T2).


* Tinh chỉnh kỹ thuật (Hardening): Kiểm thử bảo mật (Pentest), tối ưu hiệu năng, diễn tập phục hồi dữ liệu.



**Giai đoạn 5: Tổng kết & Hậu MVP (Tháng 18 trở đi)**

* Đánh giá sự thay đổi năng lực (trước - sau), tổng hợp báo cáo giới hạn mở rộng.


* Định hướng công nghệ tiếp theo: Mở rộng API cho đối tác, phát triển ứng dụng Mobile, tích hợp các tác nhân AI tự động hóa cao hơn.



---

### 3. Danh sách các Module và Phân hệ cần triển khai

Hệ thống được thiết kế theo kiến trúc 5 lớp (Thu thập, Chuẩn hóa, Bản sao số, AI phân tích, Hiển thị). Dưới đây là cấu trúc các Module và Phân hệ chi tiết:

**Module 1: IAM & Tổ chức (Identity, Access & Org Management)**

* *Phân hệ Tài khoản:* Đăng ký, đăng nhập, MFA, quản lý mã định danh nội bộ (pseudonymization).
* *Phân hệ Tổ chức & Quan hệ:* Quản lý doanh nghiệp, cơ sở đào tạo, quan hệ lao động (ngày bắt đầu/kết thúc), tự động thu hồi quyền khi kết thúc quan hệ.
* *Phân hệ Chiến dịch Pilot:* Quản lý lời mời, theo dõi trạng thái tham gia (onboarding) của người dùng.

**Module 2: CFM (Quản trị Khung năng lực - Competency Framework)**

* *Phân hệ Hồ sơ vị trí (Role Profile):* Tạo và quản lý danh mục nghề, vị trí việc làm, nhiệm vụ và yêu cầu năng lực theo từng bối cảnh.
* *Phân hệ Cấu trúc năng lực:* Cấu hình 3 lớp của khung TCF, định nghĩa tiêu chí, chỉ báo cho các mức từ M1 đến M5.


* *Phân hệ Phiên bản & Quy tắc (Versioning & Rules):* Cấu hình trọng số, quy tắc tính điểm, quản lý vòng đời phiên bản khung (nháp -> chờ duyệt -> kích hoạt -> đóng băng).



**Module 3: EVM (Quản lý Minh chứng - Evidence Intake & Review)**

* *Phân hệ Thu thập (Intake):* Upload tệp, kiểm tra định dạng (MIME/Magic bytes), quét mã độc (malware scan), băm dữ liệu (checksum).
* *Phân hệ Workflow Minh chứng:* Quản lý vòng đời trạng thái file (từ mới tiếp nhận, chờ xác minh, đến đã xác minh, thu hồi hoặc hết hiệu lực).
* *Phân hệ Ánh xạ (Mapping):* Liên kết 1 minh chứng với nhiều tiêu chí năng lực, đánh giá mức độ liên quan độc lập với trạng thái xác minh của file.

**Module 4: TWE (Động cơ Bản sao số - Twin Engine)**

* *Phân hệ Đánh giá (Assessment):* Phân công người chấm (tự đánh giá, quản lý, chuyên gia), tổng hợp kết quả đa nguồn, cảnh báo thiếu dữ liệu.
* *Phân hệ Snapshot Bất biến:* Thuật toán sinh tập dữ liệu chuẩn hóa, tạo mã băm (dấu vân tay) để so sánh trạng thái ứng viên với trạng thái hiện hành, lưu vết T0-Tn không ghi đè.


* *Phân hệ Đồ thị phụ thuộc (Dependency Graph):* Quản lý chỉ mục lan truyền ảnh hưởng, tự động nhận diện các nút năng lực cần tính toán lại khi minh chứng hoặc quy tắc bị thay đổi.



**Module 5: DEV (Phân tích khoảng cách & Phát triển)**

* *Phân hệ Gap Analysis:* So sánh năng lực hiện tại với vị trí mục tiêu, bóc tách giữa việc "thiếu năng lực" và "chưa đủ dữ liệu".
* *Phân hệ Kế hoạch phát triển:* Tạo lộ trình học tập, gán khóa học/nhiệm vụ, theo dõi tiến độ (planned, in-progress, completed).

**Module 6: AIM (Điều phối AI - AI Orchestrator)**

* *Phân hệ Tác vụ AI:* Thực thi OCR trích xuất thông tin (AI-01), AI gợi ý ánh xạ minh chứng (AI-02), AI gợi ý lộ trình phát triển.
* *Phân hệ Quản trị Model & Prompt:* Quản lý danh mục nhà cung cấp, phiên bản model, các mẫu câu lệnh (prompt templates), cơ chế kill-switch.
* *Phân hệ Kiểm soát con người (Human-in-the-loop):* Giao diện bắt buộc để chuyên gia/quản lý duyệt (chấp nhận, sửa, từ chối) các đầu ra do AI gợi ý trước khi lưu chính thức.

**Module 7: PRV (Cổng hiển thị, Báo cáo & Quyền riêng tư)**

* *Phân hệ Quyền riêng tư (Privacy):* Quản lý sự đồng ý (Consent), cấp/thu hồi quyền chia sẻ dữ liệu (Share grants), tiếp nhận yêu cầu của chủ thể dữ liệu (sửa, xóa, hạn chế).
* *Phân hệ Cổng làm việc (Portals & Dashboards):* Cung cấp giao diện riêng biệt cho Cá nhân (xem hồ sơ mình), Tổ chức (xem nhóm nhân viên), và Cơ quan quản lý (xem dữ liệu ẩn danh, áp ngưỡng nhóm nhỏ).
* *Phân hệ Nhật ký & Xuất dữ liệu (Audit & Export):* Ghi log dạng append-only cho mọi thao tác quan trọng, xuất báo cáo CSV/PDF theo phân quyền.

-------------------------------------------------------------------------------

Dựa trên các tài liệu bạn đã cung cấp, hai vấn đề bạn hỏi đều đã được xác định rất rõ ràng và chi tiết. Cụ thể như sau:

### 1. Các loại tài khoản (Vai trò người dùng) đã được xác định chưa?

Trong tài liệu Đặc tả kỹ thuật MVP (Mục 2: Nhóm người dùng và vai trò), hệ thống đã phân chia rất rõ ràng **8 loại tài khoản (vai trò) chính**. Mỗi loại tài khoản có phạm vi quyền hạn và giới hạn truy cập nghiêm ngặt:

* **Tài khoản Cá nhân:** Quản lý hồ sơ, mục tiêu, minh chứng, kết quả đánh giá và lịch sử của chính mình. Mặc định không được truy cập dữ liệu của người khác hoặc cấu hình hệ thống.


* **Tài khoản Quản lý đơn vị (Doanh nghiệp):** Xem vị trí, hồ sơ của những người có quan hệ lao động đang còn hiệu lực với đơn vị, thực hiện đánh giá/xác nhận theo ủy quyền và xem báo cáo nhóm. Không được xem dữ liệu riêng tư hoặc hồ sơ của người ngoài đơn vị.


* **Tài khoản Cơ sở đào tạo:** Quản lý chương trình, hoạt động phát triển và xem kết quả trước–sau đào tạo trong phạm vi được giao. Không được xem dữ liệu nhân sự không liên quan đến mục tiêu đào tạo.


* **Tài khoản Chuyên gia/Đánh giá viên:** Chỉ được xem các hồ sơ tối thiểu được phân công để chấm điểm, xem tiêu chí, minh chứng và đưa ra nhận xét. Không được xem thông tin định danh không cần thiết.


* **Tài khoản Quản trị nghiệp vụ (THUCHOCVN):** Quản lý cấu hình khung năng lực, quy tắc, chiến dịch pilot, phân công công việc và xử lý các yêu cầu. Không được tùy tiện sửa kết quả đã khóa hoặc phê duyệt.


* **Tài khoản Quản trị hệ thống (System Admin):** Quản lý tài khoản, cấu hình kỹ thuật, vận hành và nhật ký hệ thống. Bị cấm xem nội dung nghiệp vụ nhạy cảm nếu không được cấp quyền riêng.


* **Tài khoản Cơ quan quản lý/Quan sát:** Chỉ xem các Dashboard (bảng điều khiển) báo cáo tổng hợp, mặc định không định danh trong phạm vi thẩm quyền.


* **Tài khoản Dịch vụ AI (System/Agent Role):** Được cấp quyền hạn chế để truy cập dữ liệu tối thiểu phục vụ tác vụ đã duyệt và trả về các gợi ý (có lưu nhật ký). AI không được tự phê duyệt hoặc thay đổi trạng thái dữ liệu chính thức.

-------------------------------------------------------------------------------
Dựa trên các tài liệu đặc tả kỹ thuật MVP v0.1 và mô hình kiến trúc lõi, Phân hệ Tài khoản (Identity & Access Management - IAM) yêu cầu một thiết kế cơ sở dữ liệu (DB) cực kỳ linh hoạt.

Thiết kế này phải giải quyết được 3 bài toán lớn: **(1)** Quản lý đa nhóm đối tượng (cá nhân độc lập, cá nhân thuộc tổ chức, chuyên gia, quản trị...); **(2)** Theo dõi quan hệ giữa cá nhân và tổ chức theo thời gian (khi gia nhập, khi nghỉ việc); và **(3)** Tách bạch định danh (pseudonymization) để bảo vệ quyền riêng tư.

Dưới đây là thiết kế chi tiết các bảng CSDL (chuẩn Laravel Migration) đáp ứng hoàn toàn các yêu cầu trên.

### 1. Bảng `users` (Xác thực và Đăng nhập)

Bảng này chỉ dùng để phục vụ quá trình đăng nhập (Authentication), tách biệt hoàn toàn với dữ liệu nhân khẩu học hay kết quả đánh giá năng lực.

* `id` (UUID): Khóa chính.
* `email` / `phone_number` (String, Unique): Thông tin đăng nhập.
* `password` (String): Mật khẩu đã băm (hashed).
* `mfa_secret`, `mfa_enabled` (Boolean): Trạng thái xác thực đa yếu tố (bắt buộc với admin).


* `status` (Enum: `active`, `locked`, `suspended`): Trạng thái tài khoản.
* `last_login_at` (Timestamp): Lần đăng nhập cuối.
* `timestamps()`, `softDeletes()`: Quản lý thời gian tạo, sửa, xóa mềm.

### 2. Bảng `persons` (Định danh chủ thể - Lõi của hệ thống)

Đây là bảng cốt lõi (Person Entity). Mã `id` của bảng này đóng vai trò là "mã định danh nội bộ" (`internal_id`) để dùng trong các thuật toán tính toán và báo cáo phân tích, giúp ẩn danh thông tin thật của người dùng.

* `id` (UUID): Khóa chính, dùng làm `internal_id`.


* `user_id` (UUID): Khóa ngoại liên kết 1-1 với bảng `users`.
* `full_name` (String): Họ và tên (có thể áp dụng mã hóa cấp độ DB).
* `avatar_url` (String, Nullable).
* `is_independent` (Boolean): Flag nhanh để xác định đây là "Cá nhân tham gia độc lập" (Nhóm A) hay đã gia nhập tổ chức.


* `timestamps()`

### 3. Bảng `organizations` (Tổ chức / Đơn vị)

Quản lý các pháp nhân tham gia hệ thống, bao gồm doanh nghiệp, cơ sở đào tạo hoặc cơ quan quản lý.

* `id` (UUID): Khóa chính.
* `name` (String): Tên tổ chức.
* `org_type` (Enum: `enterprise`, `training_center`, `authority`, `system_admin`): Loại tổ chức.


* `status` (Enum: `active`, `inactive`).
* `parent_id` (UUID, Nullable): Hỗ trợ cấu trúc tổ chức dạng cây (Tổng công ty -> Chi nhánh).
* `timestamps()`

### 4. Bảng `roles` và `permissions` (Phân quyền RBAC)

Quản lý danh mục 8 nhóm vai trò cốt lõi đã định nghĩa.

* `id` (UUID)
* `name` (String): Tên vai trò (VD: `individual`, `org_manager`, `assessor`, `system_admin`).
* `guard_name` (String): Mặc định của Laravel.

### 5. Bảng `memberships` (Quan hệ Cá nhân - Tổ chức theo thời gian)

Đây là bảng giải quyết bài toán phức tạp nhất: **Sự thay đổi bối cảnh của người dùng** (IAM-03). Một người có thể hôm nay là nhân viên công ty A (Nhóm B), ngày mai nghỉ việc thành lao động tự do (Nhóm A), sau đó gia nhập công ty B.

* `id` (UUID): Khóa chính.
* `person_id` (UUID): Khóa ngoại trỏ đến người lao động.
* `organization_id` (UUID): Khóa ngoại trỏ đến tổ chức.
* `role_id` (UUID): Vai trò của người này TRONG tổ chức đó (VD: nhân viên, quản lý).
* `effective_from` (Datetime): Ngày bắt đầu có hiệu lực quan hệ.
* `effective_to` (Datetime, Nullable): Ngày kết thúc quan hệ (ngày nghỉ việc).


* `status` (Enum: `active`, `expired`, `terminated`): Trạng thái của quan hệ.
* `timestamps()`

### Phân tích cách thiết kế này giải quyết bài toán của dự án:

1. **Chuyển đổi linh hoạt giữa Nhóm A và Nhóm B:** Khi một người dùng đăng ký, họ có một record ở `users` và `persons` với `is_independent = true`. Khi họ được doanh nghiệp mời vào hệ thống, một record mới được tạo trong bảng `memberships`. Hệ thống dựa vào bảng `memberships` để tự động chuyển context giao diện hiển thị thành Nhóm B.


2. **Bảo vệ dữ liệu lịch sử khi nghỉ việc:** Khi nhân sự rời doanh nghiệp, ta không xóa record trong bảng `memberships`, mà chỉ cập nhật trường `effective_to = now()` và `status = terminated`. Lập tức (nhờ Global Scope của Laravel), Quản lý của doanh nghiệp đó sẽ bị thu hồi quyền truy cập vào hồ sơ năng lực của nhân sự này. Đồng thời, lịch sử Bản sao số năng lực của cá nhân vẫn được bảo toàn nguyên vẹn.


3. **Tối ưu báo cáo ẩn danh:** Khi Cơ quan quản lý cần xem Dashboard (DB-03), hệ thống truy vấn dữ liệu từ các bảng `memberships` và bảng `twin_snapshots` (bảng điểm năng lực) thông qua `person_id` (mã nội bộ) mà không cần JOIN (kết nối) với bảng `users` hay truy xuất `full_name`. Điều này đáp ứng 100% yêu cầu "Mặc định không định danh".

-------------------------------------------------------------------------------

Dựa trên tài liệu Đặc tả kỹ thuật MVP v0.1 và Bản thuyết minh chi tiết, Phân hệ Tổ chức & Quan hệ (Organization & Relationship Management) là cầu nối then chốt quyết định việc phân quyền theo ngữ cảnh (ABAC) và theo dõi lịch sử thay đổi bối cảnh của người dùng.

Đúng theo yêu cầu của bạn, để đảm bảo tính chuẩn hóa CSDL (Normalization) mức cao nhất và **tuyệt đối không sử dụng kiểu dữ liệu JSON** (điều này rất quan trọng để tối ưu hóa tốc độ truy vấn `JOIN` khi áp dụng Global Scopes trong Laravel), dưới đây là bản thiết kế chi tiết:

### 1. Phân tích nguyên tắc thiết kế từ tài liệu

* **Quản lý tổ chức và đơn vị con (IAM-02):** Cần quản lý loại tổ chức, trạng thái và không được xóa cứng (hard-delete) dữ liệu đã phát sinh.


* **Theo dõi quan hệ theo thời gian (IAM-03):** Quan hệ giữa cá nhân và tổ chức phải có ngày bắt đầu (`effective_from`) và ngày kết thúc (`effective_to`); khi kết thúc quan hệ, quyền truy cập của tổ chức tự động bị thu hồi.


* **Chiến dịch thử nghiệm (IAM-04):** Cần theo dõi trạng thái tham gia của người dùng qua các bước: được mời (invited), chấp nhận (accepted), đang tham gia (active), rút lui (withdrawn), hoàn thành (completed).


* **Sự đồng ý & Chia sẻ dữ liệu (SEC-01):** Việc chia sẻ phải gắn với mục đích, phạm vi dữ liệu, bên nhận, thời hạn và có thể thu hồi. (Vì không dùng JSON, ta phải thiết kế các bảng phụ (child tables) để lưu chi tiết các hạng mục được chia sẻ).



---

### 2. Thiết kế Cơ sở dữ liệu (Database Schema)

Tất cả các bảng dưới đây sử dụng khóa chính dạng ULID/UUID v7 (không dùng UUID v4 ngẫu nhiên — xem khuyến nghị hiệu chỉnh hiệu năng tại phân hệ Đồ thị phụ thuộc, Mục 4) và tích hợp `timestamps()`, `softDeletes()` để không xóa cứng dữ liệu.

#### Nhóm 2.1: Tổ chức & Cấu trúc đơn vị (Organizations)

**Bảng 1: `organizations` (Danh mục Tổ chức/Doanh nghiệp)**

* `id` (UUID, Primary)
* `parent_id` (UUID, Nullable, Foreign Key -> `organizations.id`): Quản lý cấu trúc đơn vị con/phòng ban trực thuộc.


* `name` (String): Tên tổ chức.
* `org_type` (Enum/String): Loại tổ chức (VD: `enterprise` - doanh nghiệp, `training_center` - cơ sở đào tạo, `authority` - cơ quan quản lý).


* `status` (Enum/String): Trạng thái hoạt động (`active`, `locked`, `inactive`).


* `tax_code` (String, Nullable): Mã số thuế / Mã định danh pháp nhân.

#### Nhóm 2.2: Quan hệ Cá nhân - Tổ chức (Memberships)

**Bảng 2: `memberships` (Quản lý trạng thái làm việc/học tập)**
Bảng này liên kết bảng `persons` (từ phân hệ Tài khoản) với `organizations`.

* `id` (UUID, Primary)
* `person_id` (UUID, Foreign Key -> `persons.id`): Trỏ đến mã định danh nội bộ của cá nhân.


* `organization_id` (UUID, Foreign Key -> `organizations.id`)
* `position_id` (UUID, Nullable): Trỏ đến mã Vị trí việc làm (sẽ định nghĩa ở module Khung năng lực).


* `org_role_id` (UUID): Vai trò của cá nhân trong tổ chức này (VD: Nhân viên, Quản lý, Giám đốc).
* `effective_from` (Datetime): Thời điểm bắt đầu có hiệu lực (ngày nhận việc/nhập học).


* `effective_to` (Datetime, Nullable): Thời điểm kết thúc (ngày nghỉ việc/tốt nghiệp).


* `status` (Enum/String): `active` (đang hiệu lực), `expired` (đã hết hạn), `terminated` (đã chấm dứt).



#### Nhóm 2.3: Chiến dịch Pilot & Onboarding (Campaigns)

**Bảng 3: `pilot_campaigns` (Chiến dịch Thử nghiệm)**

* `id` (UUID, Primary)
* `organization_id` (UUID, Foreign Key -> `organizations.id`): Tổ chức chủ trì chiến dịch.
* `name` (String): Tên chiến dịch (VD: Đánh giá năng lực NV Kho 2026).


* `start_date` (Date)
* `end_date` (Date, Nullable)
* `status` (Enum/String): `draft`, `active`, `completed`, `cancelled`.



**Bảng 4: `campaign_participants` (Theo dõi trạng thái người tham gia)**

* `id` (UUID, Primary)
* `campaign_id` (UUID, Foreign Key -> `pilot_campaigns.id`)
* `person_id` (UUID, Foreign Key -> `persons.id`)
* `status` (Enum/String): `invited` (đã mời), `accepted` (đã chấp nhận), `active` (đang tham gia), `withdrawn` (rút lui), `completed` (đã hoàn thành).


* `invited_at` (Datetime)
* `responded_at` (Datetime, Nullable): Thời điểm người dùng phản hồi lời mời.

#### Nhóm 2.4: Sự Đồng ý & Phân quyền Chia sẻ (Consent & Share Grants)

Lưu ý: Để tuân thủ yêu cầu KHÔNG dùng JSON cho các mảng như `data_categories` hay `scopes`, ta chuẩn hóa thành mô hình bảng cha - bảng con.

**Bảng 5: `consents` (Ghi nhận Sự đồng ý về pháp lý)**

* `id` (UUID, Primary)
* `person_id` (UUID, Foreign Key)
* `organization_id` (UUID, Foreign Key): Tổ chức yêu cầu sự đồng ý.
* `purpose` (String): Mục đích xử lý dữ liệu (VD: `pilot_evaluation`).


* `legal_basis` (String): Căn cứ pháp lý (VD: `consent`, `contract`).


* `status` (Enum/String): `active`, `withdrawn`, `expired`.


* `granted_at` (Datetime): Thời điểm đồng ý.
* `expires_at` (Datetime, Nullable): Thời hạn đồng ý.


* `proof_reference` (String, Nullable): Mã tham chiếu minh chứng đồng ý.



**Bảng 6: `consent_scopes` (Phạm vi dữ liệu cho phép - Thay thế Array JSON)**

* `id` (UUID, Primary)
* `consent_id` (UUID, Foreign Key -> `consents.id`)
* `data_category` (String): Tên nhóm dữ liệu (VD: `learning_history`, `evidence_files`, `assessment_results`).


* `is_allowed` (Boolean): Mặc định là True. Nếu người dùng rút quyền một phần, set về False.

**Bảng 7: `share_grants` (Cấp quyền chia sẻ trực tiếp dữ liệu cá nhân)**

* `id` (UUID, Primary)
* `person_id` (UUID, Foreign Key): Người chủ động chia sẻ.


* `recipient_org_id` (UUID, Foreign Key): Tổ chức nhận dữ liệu.


* `purpose` (String): Mục đích chia sẻ.


* `valid_from` (Datetime)
* `valid_until` (Datetime, Nullable)
* `status` (Enum/String): `active`, `revoked`, `expired`.



**Bảng 8: `share_grant_items` (Chi tiết các Bản sao số/Minh chứng được chia sẻ)**

* `id` (UUID, Primary)
* `share_grant_id` (UUID, Foreign Key -> `share_grants.id`)
* `object_type` (String): Tên Model được chia sẻ (VD: `TwinSnapshot`, `Evidence`).


* `object_id` (UUID): ID cụ thể của đối tượng đó.

---

### 3. Đánh giá cách thiết kế này giải quyết bài toán cốt lõi

1. **Loại bỏ hoàn toàn JSON:** Bằng cách sử dụng bảng `consent_scopes` và `share_grant_items`, hệ thống có thể dùng các câu lệnh SQL JOIN truyền thống (hoặc Eloquent Relationships trong Laravel: `hasMany`, `belongsTo`) để kiểm tra quyền ABAC một cách cực kỳ nhanh chóng và chính xác ở cấp độ `row-level`.


2. **Tự động hóa bảo vệ quyền riêng tư:** Khi một nhân sự nghỉ việc, hệ thống chỉ cần cập nhật trường `status = terminated` và `effective_to = now()` ở bảng `memberships`. Ngay lập tức, mọi truy vấn dữ liệu từ tài khoản Quản lý Doanh nghiệp (dựa vào `organization_id`) sẽ tự động loại trừ nhân sự này, đáp ứng nguyên tắc "thu hồi quyền tự động".


3. **Toàn vẹn Audit Log:** Thiết kế này tạo ra các bản ghi rõ ràng cho mọi trạng thái Onboarding hay rút lại sự đồng ý (`withdrawn`), giúp dễ dàng ghi Log (Nhật ký) theo quy định bảo vệ dữ liệu cá nhân.



Thiết kế này đã chuẩn bị nền tảng hoàn hảo để gắn kết với Module Khung năng lực (CFM) ở bước tiếp theo. Bạn có muốn chúng ta tiếp tục đi vào thiết kế CSDL cho Module Khung năng lực (nơi chứa các bảng cấu hình tiêu chí M1-M5 và từ điển năng lực) không?

-------------------------------------------------------------------------------

Dựa trên tài liệu Đặc tả kỹ thuật MVP v0.1 (đặc biệt là yêu cầu **IAM-04**) và Bản thuyết minh chi tiết về thiết kế thử nghiệm, **Phân hệ Chiến dịch Pilot (Pilot Campaign Management)** đóng vai trò là "phễu lọc" để tuyển chọn, theo dõi và quản lý vòng đời tham gia của người dùng.

Để giải quyết triệt để yêu cầu **KHÔNG sử dụng JSON** đối với các trường dữ liệu phức tạp như "nhóm đối tượng" hay "điều kiện tham gia", thiết kế cơ sở dữ liệu dưới đây sẽ thực hiện chuẩn hóa (Normalization) mức cao bằng cách chia nhỏ thành các bảng quan hệ (Relational Tables).

Dưới đây là phân tích và thiết kế CSDL chi tiết cho Phân hệ Chiến dịch Pilot:

### 1. Phân tích nguyên tắc thiết kế từ tài liệu

* **Quản lý chiến dịch và đối tượng (IAM-04):** Hệ thống cần tạo được chiến dịch pilot, xác định nhóm đối tượng mục tiêu, điều kiện tham gia và phát hành lời mời.


* **Theo dõi trạng thái Onboarding (IAM-04):** Bắt buộc phải theo dõi sát sao tiến trình của từng cá nhân qua các trạng thái: `invited` (đã mời), `accepted` (đã chấp nhận), `active` (đang tham gia), `withdrawn` (rút lui), `completed` (đã hoàn thành).


* **Sự đồng ý và tự nguyện:** Việc tham gia pilot phải dựa trên sự tự nguyện và người dùng phải xác nhận đồng ý với các điều khoản xử lý dữ liệu.


* **Liên kết vị trí mục tiêu:** Mỗi chiến dịch sẽ nhắm đến một hoặc một vài vị trí việc làm mục tiêu (ví dụ: Nhân sự kho, Tư vấn viên) để kích hoạt phiên bản khung năng lực tương ứng.



---

### 2. Thiết kế Cơ sở dữ liệu (Database Schema)

Các bảng thiết kế sử dụng ULID/UUID v7 làm khóa chính (thay UUID v4 truyền thống — xem khuyến nghị hiệu chỉnh hiệu năng tại phân hệ Đồ thị phụ thuộc, Mục 4), tích hợp `timestamps()` và `softDeletes()` để bảo toàn lịch sử dữ liệu.

#### Bảng 1: `pilot_campaigns` (Thông tin gốc của Chiến dịch)

Lưu trữ thông tin tổng quan, thời hạn và trạng thái của chiến dịch.

* `id` (UUID, Primary)
* `organization_id` (UUID, Nullable, Foreign Key -> `organizations.id`): Đơn vị chủ trì (Nếu THUCHOCVN chủ trì toàn hệ thống thì để null, nếu một doanh nghiệp cụ thể tự chạy pilot nội bộ thì điền ID doanh nghiệp).


* `name` (String): Tên chiến dịch (VD: "Đánh giá năng lực Khối Vận hành 2026").
* `description` (Text, Nullable): Mô tả mục tiêu chiến dịch.
* `start_date` (Date): Ngày bắt đầu.
* `end_date` (Date, Nullable): Ngày kết thúc.
* `status` (Enum/String): `draft` (bản nháp), `active` (đang chạy), `completed` (đã hoàn thành), `cancelled` (đã hủy).



#### Bảng 2: `campaign_target_positions` (Nhóm đối tượng / Vị trí mục tiêu)

*Giải quyết việc không dùng JSON array để lưu danh sách các vị trí áp dụng trong chiến dịch.*

* `id` (UUID, Primary)
* `campaign_id` (UUID, Foreign Key -> `pilot_campaigns.id`)
* `position_id` (UUID, Foreign Key): Trỏ đến bảng Vị trí việc làm (sẽ định nghĩa ở module Khung năng lực).


* `target_quota` (Integer, Nullable): Số lượng chỉ tiêu hồ sơ dự kiến cho vị trí này (VD: Cần 50 hồ sơ Nhân viên QC).

#### Bảng 3: `campaign_eligibility_rules` (Điều kiện tham gia chiến dịch)

Đây là bảng quan trọng để thay thế trường JSON `eligibility_conditions`. Thay vì lưu object `{"age": ">18", "org_type": "enterprise"}`, ta chuẩn hóa thành các dòng logic.

* `id` (UUID, Primary)
* `campaign_id` (UUID, Foreign Key -> `pilot_campaigns.id`)
* `attribute_name` (String): Tên thuộc tính cần kiểm tra (VD: `employment_status`, `age`, `department`).
* `operator` (Enum/String): Toán tử so sánh (`=`, `>`, `<`, `IN`, `NOT IN`).
* `attribute_value` (String): Giá trị điều kiện để hệ thống đối chiếu lọc danh sách.

#### Bảng 4: `campaign_participants` (Quản lý trạng thái Onboarding của Cá nhân)

Bảng này đáp ứng trực tiếp yêu cầu theo dõi vòng đời người tham gia (IAM-04). Liên kết giữa cá nhân (`persons`) và chiến dịch (`pilot_campaigns`).

* `id` (UUID, Primary)
* `campaign_id` (UUID, Foreign Key -> `pilot_campaigns.id`)
* `person_id` (UUID, Foreign Key -> `persons.id`)
* `target_position_id` (UUID, Nullable, Foreign Key): Vị trí cụ thể mà cá nhân này được gán trong chiến dịch.
* `status` (Enum/String): `invited` (hệ thống đã gửi lời mời), `accepted` (người dùng đồng ý), `active` (đã hoàn thiện hồ sơ ban đầu/T0), `withdrawn` (người dùng xin rút lui), `completed` (đã hoàn thành chu trình T1/Tn).


* `invited_at` (Datetime): Thời điểm phát hành lời mời.
* `responded_at` (Datetime, Nullable): Thời điểm người dùng click "Chấp nhận" hoặc "Từ chối".
* `completed_at` (Datetime, Nullable): Thời điểm chốt kết quả đợt pilot cho cá nhân này.

#### Bảng 5: `campaign_consent_records` (Hồ sơ pháp lý: Sự đồng ý tham gia)

Bảo đảm tính tuân thủ pháp lý theo thiết kế Privacy by Design. Cá nhân tham gia phải xác nhận đồng ý xử lý dữ liệu.

* `id` (UUID, Primary)
* `campaign_participant_id` (UUID, Foreign Key -> `campaign_participants.id`)
* `consent_id` (UUID, Foreign Key -> `consents.id` - liên kết với bảng `consents` ở Phân hệ Quan hệ & Tổ chức đã thiết kế trước đó).
* `agreed_at` (Datetime): Thời điểm ký/xác nhận điện tử.

---

### 3. Đánh giá tính tối ưu và ứng dụng của Thiết kế

1. **Tuân thủ tuyệt đối quy tắc Anti-JSON:** Thay vì nhồi nhét "Nhóm đối tượng" và "Điều kiện lọc" vào các cột JSON (gây khó khăn cho Query Builder của Laravel khi muốn lọc dữ liệu lớn), thiết kế bảng `campaign_eligibility_rules` và `campaign_target_positions` cho phép dùng các truy vấn `JOIN` hoặc `EXISTS` thuần túy trong SQL. Điều này tăng tốc độ truy vấn khi hệ thống dùng Cronjob để quét danh sách và gửi hàng loạt email lời mời (invited).
2. **Tracking vòng đời Onboarding rõ nét (IAM-04):** Bảng `campaign_participants` đóng vai trò là "Sổ điểm danh". Quản trị viên (THUCHOCVN hoặc Doanh nghiệp) nhìn vào bảng này có thể vẽ được phễu chuyển đổi (Funnel): Bao nhiêu người được mời (`invited`) $\rightarrow$ Bao nhiêu người phản hồi (`responded_at`) $\rightarrow$ Bao nhiêu người đang hoạt động tạo minh chứng (`active`) $\rightarrow$ Bao nhiêu người rụng (`withdrawn`).


3. **Chuẩn bị dữ liệu cho Module Kế tiếp (Khung năng lực & Đánh giá):** Bảng `campaign_participants` đã chốt được `person_id` và `target_position_id`. Ngay khi trạng thái chuyển sang `active`, hệ thống sẽ kích hoạt Module Khung Năng Lực (CFM) để kéo chính xác phiên bản khung năng lực tương ứng với vị trí đó, làm cơ sở để người dùng bắt đầu nộp minh chứng thiết lập trạng thái T0.

-------------------------------------------------------------------------------

Dựa trên bản Đặc tả MVP v0.1 (Yêu cầu CF-01, CF-02) và Khung năng lực mẫu TCF v1.0 (Mục 8: Mẫu hồ sơ yêu cầu theo vị trí việc làm), Phân hệ **Hồ sơ vị trí (Role Profile)** đóng vai trò là "Lớp thứ 3" trong kiến trúc khung năng lực. Nó kết nối các năng lực trừu tượng (Lớp 1 & Lớp 2) với bối cảnh thực tế của một doanh nghiệp (Nhiệm vụ, Mức yêu cầu, Loại minh chứng bắt buộc).

Đặc biệt, hệ thống yêu cầu quản lý phiên bản nghiêm ngặt (không ghi đè bản cũ). Để tuân thủ nguyên tắc **KHÔNG sử dụng JSON**, chúng ta phải phân rã các mảng dữ liệu (như danh sách nhiệm vụ, danh sách năng lực yêu cầu, quy định minh chứng) thành các bảng quan hệ (Relational Tables).

Dưới đây là thiết kế CSDL chi tiết cho Phân hệ Hồ sơ vị trí (Role Profile):

### 1. Phân tích nguyên tắc thiết kế từ tài liệu

* **Thông tin định danh và bối cảnh:** Cần xác định vị trí đó thuộc nhóm nghề nào, của tổ chức nào, và quản lý theo phiên bản (version).


* **Mục tiêu và Nhiệm vụ:** Phải liệt kê chi tiết mục tiêu, đối tượng phục vụ, các nhiệm vụ chính, tần suất và mức độ phức tạp.


* **Năng lực yêu cầu:** Map (ánh xạ) vị trí này với các mã năng lực (TCF/TICF), quy định mức tối thiểu, mức mục tiêu và tính bắt buộc.


* **Quy định Minh chứng:** Xác định rõ vị trí này cần nộp loại minh chứng nào, số lượng bao nhiêu, nguồn từ đâu và thời hạn hiệu lực.


* **Liên kết module trước:** `job_position_id` của phân hệ này chính là khóa ngoại được gọi từ bảng `memberships` (Phân hệ IAM) và `campaign_target_positions` (Phân hệ Pilot) đã thiết kế trước đó.

---

### 2. Thiết kế Cơ sở dữ liệu (Database Schema)

Tất cả các bảng dưới đây sử dụng khóa chính dạng ULID/UUID v7 (thay UUID v4 truyền thống — xem khuyến nghị hiệu chỉnh hiệu năng tại phân hệ Đồ thị phụ thuộc, Mục 4), có `timestamps()` và `softDeletes()`.

#### Nhóm 2.1: Danh mục Định danh (Danh mục gốc)

**Bảng 1: `job_families` (Nhóm nghề / Lĩnh vực)**
Lưu trữ danh mục nhóm nghề chuẩn (VD: Quản lý chất lượng, Sản xuất, Dịch vụ tài chính).

* `id` (UUID, Primary)
* `code` (String, Unique): Mã nhóm nghề.
* `name` (String): Tên nhóm nghề.
* `description` (String, Nullable).

**Bảng 2: `job_positions` (Danh mục Vị trí việc làm - Gốc)**
Định danh vị trí việc làm độc lập với các phiên bản yêu cầu.

* `id` (UUID, Primary)
* `organization_id` (UUID, Nullable, Foreign Key -> `organizations.id`): Nếu vị trí dùng chung toàn hệ thống thì Null, nếu là vị trí đặc thù của doanh nghiệp thì trỏ về ID doanh nghiệp.


* `job_family_id` (UUID, Foreign Key -> `job_families.id`)
* `code` (String): Mã vị trí (VD: `QC-01`).
* `name` (String): Tên vị trí (VD: `Chuyên viên Quản lý chất lượng`).
* `status` (Enum/String): `active`, `inactive`.

#### Nhóm 2.2: Hồ sơ vị trí & Phiên bản (Role Profiles)

**Bảng 3: `role_profiles` (Phiên bản Hồ sơ vị trí - Lõi)**
Quản lý các phiên bản yêu cầu của một vị trí theo thời gian, tuân thủ nguyên tắc không ghi đè.

* `id` (UUID, Primary)
* `job_position_id` (UUID, Foreign Key -> `job_positions.id`)
* `version` (String): Mã phiên bản (VD: `v1.0.0`).


* `status` (Enum/String): `draft` (nháp), `active` (đang hiệu lực), `retired` (đã thu hồi/thay thế).


* `effective_from` (Datetime): Thời điểm bắt đầu áp dụng phiên bản này.


* `effective_to` (Datetime, Nullable): Thời điểm kết thúc.


* `target_output` (String): Giá trị đầu ra / Mục tiêu vị trí.


* `responsibility_scope` (String): Phạm vi trách nhiệm.


* `review_cycle_months` (Integer): Chu kỳ rà soát hồ sơ (số tháng).


* `approver_id` (UUID, Nullable): ID người phê duyệt.



#### Nhóm 2.3: Yêu cầu Công việc chi tiết (Child tables thay thế JSON)

**Bảng 4: `role_profile_tasks` (Nhiệm vụ chính của vị trí)**
Thay vì lưu mảng các nhiệm vụ vào JSON, ta tách thành bảng con.

* `id` (UUID, Primary)
* `role_profile_id` (UUID, Foreign Key -> `role_profiles.id`)
* `name` (String): Tên nhiệm vụ.
* `frequency` (Enum/String): Tần suất (VD: `daily`, `weekly`, `monthly`, `ad_hoc`).


* `complexity_level` (String): Mức độ phức tạp.


* `risk_level` (String): Mức độ rủi ro.



**Bảng 5: `role_profile_competencies` (Ánh xạ Năng lực yêu cầu)**
Bảng này map Lớp 3 (Hồ sơ vị trí) với Lớp 1 & Lớp 2 (Khung năng lực cốt lõi).

* `id` (UUID, Primary)
* `role_profile_id` (UUID, Foreign Key -> `role_profiles.id`)
* `competency_id` (UUID, Foreign Key): Trỏ đến mã năng lực trong bảng `competencies` (VD: mã `DAT-03` - Quản trị dữ liệu).


* `min_level` (Integer): Mức thành thạo tối thiểu yêu cầu (VD: `2`).


* `target_level` (Integer): Mức mục tiêu kỳ vọng (VD: `3`).


* `is_mandatory` (Boolean): Năng lực bắt buộc (`true`) hay bổ trợ (`false`).



**Bảng 6: `role_profile_evidences` (Quy định tiêu chuẩn Minh chứng)**
Kiểm soát chặt chẽ người dùng phải nộp đúng loại giấy tờ nào để chứng minh cho một năng lực thuộc vị trí này.

* `id` (UUID, Primary)
* `role_profile_competency_id` (UUID, Foreign Key -> `role_profile_competencies.id`): Gắn quy định minh chứng vào đích danh một năng lực của vị trí đó.
* `evidence_type` (String): Loại minh chứng (VD: `certificate`, `work_product`, `performance_log`).


* `min_quantity` (Integer): Số lượng tối thiểu cần nộp (VD: Cần ít nhất 2 báo cáo).


* `required_verification_source` (String): Nguồn xác minh bắt buộc (VD: `direct_manager`, `training_center`).


* `validity_months` (Integer): Thời hạn hiệu lực của minh chứng (VD: Chứng chỉ này chỉ có giá trị tính điểm trong `24` tháng).



**Bảng 7: `role_profile_assessments` (Cấu hình Quy tắc Đánh giá)**

* `id` (UUID, Primary)
* `role_profile_id` (UUID, Foreign Key -> `role_profiles.id`)
* `assessment_method` (Enum/String): Phương pháp đánh giá (VD: `self_assessment`, `manager_review`, `expert_review`, `360_degree`).


* `assessor_role_id` (UUID, Nullable): Ai là người có quyền đánh giá (Trỏ về bảng `roles` ở phân hệ IAM).


* `conflict_resolution_rule` (String): Cơ chế xử lý khi có mâu thuẫn điểm số (VD: `require_expert`, `take_manager_score`).



---

### 3. Đánh giá sự kết nối & Khả năng vận hành của Thiết kế

1. **Tính bất biến và Toàn vẹn lịch sử (Versioning):** Khi doanh nghiệp muốn thay đổi yêu cầu năng lực cho nhân viên (ví dụ nâng mức yêu cầu năng lực AI từ M2 lên M3), hệ thống KHÔNG sửa trên bản ghi cũ. Thay vào đó, nó tạo một `role_profiles` mới với `version` cao hơn, copy các task/competencies sang bản mới và cập nhật `target_level`. Các Bản sao số (T0) đã được chấm ở version cũ sẽ không bị ảnh hưởng, thỏa mãn tuyệt đối yêu cầu BR-06 và BR-08.


2. **Khả năng mở rộng cho AI (AI Orchestrator):** Vì chúng ta không dùng JSON, các bảng `role_profile_tasks` và `role_profile_competencies` có cấu trúc rất tường minh. Khi AI (Use case AI-04) thực hiện chấm điểm, hệ thống có thể dễ dàng lấy danh sách text từ các bảng này ghép vào Prompt: *"Đối chiếu minh chứng tải lên với nhiệm vụ {task_name} và kiểm tra xem có đạt mức {target_level} không"*.


3. **Tích hợp hoàn hảo với module kề trước:** Trong phân hệ Pilot Campaign đã có bảng `campaign_participants` lưu trường `target_position_id`. Khi một chiến dịch bắt đầu, hệ thống chỉ cần query `SELECT * FROM role_profiles WHERE job_position_id = ? AND status = 'active'` để hiển thị chính xác bộ tiêu chuẩn chấm điểm cho người tham gia đó.

-------------------------------------------------------------------------------
Dựa trên các tài liệu Đặc tả kỹ thuật MVP v0.1 (yêu cầu CF-02, CF-04, BR-06), Khung năng lực mẫu TCF v1.0 (kiến trúc phân cấp từ Miền năng lực đến Chỉ báo), và Bản mô tả sáng chế (quản lý phiên bản từ điển năng lực), **Phân hệ Cấu trúc năng lực (Competency Framework Management - CFM)** chính là "Từ điển gốc" (Dictionary) của toàn bộ hệ thống.

Để tuân thủ tuyệt đối nguyên tắc **KHÔNG sử dụng JSON** đối với cấu trúc phân cấp sâu và đảm bảo tính bất biến của lịch sử đánh giá (Versioning), CSDL của phân hệ này phải được thiết kế chuẩn hóa hoàn toàn (Fully Normalized). Dưới đây là phân tích và thiết kế chi tiết:

### 1. Phân tích ngữ cảnh và đối tượng sâu rộng

* **Tính phân cấp sâu (Hierarchy):** Kiến trúc khung TCF yêu cầu phân cấp 7 tầng: *Khung (Framework) $\rightarrow$ Miền (Domain) $\rightarrow$ Nhóm (Group) $\rightarrow$ Năng lực (Competency) $\rightarrow$ Mức độ thành thạo (Level) $\rightarrow$ Tiêu chí (Criterion) $\rightarrow$ Chỉ báo (Indicator)*. Việc không dùng JSON bắt buộc chúng ta phải tạo một chuỗi các bảng cha-con liên kết chặt chẽ bằng Khóa ngoại (Foreign Keys).


* **Tính bất biến (Immutability) và Phiên bản (Versioning):** Theo nguyên tắc BR-06 và CF-04, khi một tiêu chí hay chỉ báo bên trong bị thay đổi, hệ thống tuyệt đối không ghi đè lên bản ghi đang có hiệu lực. Hệ thống phải nhân bản (clone) thành một Phiên bản Khung mới (ví dụ: từ v1.0 lên v1.1) và thiết lập ngày có hiệu lực mới (`effective_from`). Điều này đảm bảo các trạng thái Bản sao số (T0, T1) trong quá khứ khi truy xuất ngược vẫn trỏ đúng về định nghĩa cũ.


* **Hỗ trợ AI ánh xạ:** Việc bóc tách từng "Tiêu chí" và "Chỉ báo" thành các dòng (rows) riêng biệt trong CSDL giúp tác nhân AI (Use case AI-02, AI-04) dễ dàng query (truy vấn) các đoạn text này để đưa vào LLM Prompt đối chiếu với minh chứng, thay vì phải parse một khối JSON khổng lồ.



---

### 2. Thiết kế Cơ sở dữ liệu (Database Schema)

Tất cả các bảng đều sử dụng khóa chính dạng ULID/UUID v7 (thay UUID v4 truyền thống — xem khuyến nghị hiệu chỉnh hiệu năng tại phân hệ Đồ thị phụ thuộc, Mục 4), có `timestamps()` và `softDeletes()`.

#### Nhóm 2.1: Quản lý Phiên bản gốc (The Root)

**Bảng 1: `competency_frameworks` (Danh mục Phiên bản Khung)**
Đây là bảng gốc rễ, quản lý tính bất biến của toàn bộ từ điển năng lực.

* `id` (UUID, Primary)
* `code` (String): Mã khung (VD: `TCF-01`).


* `name` (String): Tên khung (VD: `THUCHOCVN Competency Framework`).


* `version` (String): Phiên bản (VD: `v1.0`).


* `status` (Enum/String): `draft` (nháp), `in_review` (chờ duyệt), `active` (đang hiệu lực), `retired` (đã thu hồi).


* `effective_from` (Datetime): Thời điểm bắt đầu áp dụng phiên bản này.
* `effective_to` (Datetime, Nullable): Thời điểm kết thúc hiệu lực.
* `description` (Text, Nullable).

#### Nhóm 2.2: Cấu trúc phân tầng Năng lực (The Hierarchy)

**Bảng 2: `competency_domains` (Miền năng lực)**
Đại diện cho các nhóm lớn như Năng lực nền tảng, Năng lực số, AI trong công việc.

* `id` (UUID, Primary)
* `framework_id` (UUID, Foreign Key $\rightarrow$ `competency_frameworks.id`): Gắn chặt với một phiên bản khung cụ thể.
* `code` (String): Mã miền (VD: `WSE`, `COL`, `DAT`, `DIG`, `AIW`, `SET`).


* `name` (String): Tên miền (VD: `Làm việc và tự quản trị`).


* `focus_area` (String): Trọng tâm của miền (VD: `Thực hiện công việc, giải quyết vấn đề...`).



**Bảng 3: `competencies` (Năng lực lõi)**
Định nghĩa năng lực cụ thể. Cột `id` của bảng này sẽ được bảng `role_profile_competencies` ở phân hệ trước gọi tới.

* `id` (UUID, Primary)
* `domain_id` (UUID, Foreign Key $\rightarrow$ `competency_domains.id`)
* `code` (String): Mã năng lực (VD: `WSE-01`, `AIW-02`).


* `name` (String): Tên năng lực (VD: `Tương tác và sử dụng AI`).


* `definition` (Text): Định nghĩa chi tiết (VD: `Xác định nhiệm vụ, cung cấp ngữ cảnh, hướng dẫn...`).


* `scope_and_exclusion` (Text, Nullable): Phạm vi và những trường hợp không bao gồm trong năng lực này.



#### Nhóm 2.3: Thang đo, Tiêu chí và Chỉ báo (The Metrics)

*Đây là phần quan trọng nhất để phá vỡ cấu trúc JSON, giúp thiết kế đạt chuẩn Normalization cao.*

**Bảng 4: `proficiency_levels` (Thang mức thành thạo của Năng lực)**
Định nghĩa các mức từ M1 đến M5 (và mức M0 - Chưa đủ dữ liệu) cho từng năng lực.

* `id` (UUID, Primary)
* `competency_id` (UUID, Foreign Key $\rightarrow$ `competencies.id`)
* `level_value` (Integer): Giá trị số học (`0`, `1`, `2`, `3`, `4`, `5`). Cực kỳ quan trọng để Rules Engine tính toán điểm số bằng các phép toán MAX, MIN, AVG.


* `level_code` (String): Mã mức (VD: `M1`, `M3`, `M5`).


* `general_behavior` (Text): Biểu hiện tổng quát của mức này.


* `autonomy_responsibility` (Text): Mức độ tự chủ, trách nhiệm và ảnh hưởng.

* Lưu ý: Hiệu chỉnh logic toán học cho Mức 0 ("Chưa đủ dữ liệu") - Vấn đề: Trong bảng proficiency_levels, mức "Chưa đủ dữ liệu" được gán level_value = 0. Trong bảng assessment_criterion_results, hệ thống cũng lưu numeric_score.  Khuyến nghị hiệu chỉnh: Cần phải ghi chú rõ cho đội dev (trong Rules Engine) rằng 0 ở đây mang ý nghĩa là NULL (không có giá trị) về mặt toán học, chứ không phải là giá trị 0. Nếu đưa số 0 vào công thức tính trung bình cộng (AVG), nó sẽ kéo tụt điểm năng lực của ứng viên một cách sai lệch. Chỉ tính toán trên các tiêu chí có level_value > 0.


**Bảng 5: `criteria` (Tiêu chí đánh giá)**
Cụ thể hóa yêu cầu để đạt được một mức thành thạo.

* `id` (UUID, Primary)
* `proficiency_level_id` (UUID, Foreign Key $\rightarrow$ `proficiency_levels.id`)
* `name` (String): Tên tiêu chí ngắn gọn.
* `passing_condition` (Text): Điều kiện đạt (VD: `Phân tích nguyên nhân, so sánh giải pháp và kiểm tra hiệu quả`).



**Bảng 6: `indicators` (Chỉ báo hành vi)**
Các biểu hiện vi mô, quan sát được bằng mắt hoặc máy móc. Đây là bảng mà AI sẽ "đọc" nhiều nhất để đối chiếu với tài liệu minh chứng.

* `id` (UUID, Primary)
* `criterion_id` (UUID, Foreign Key $\rightarrow$ `criteria.id`)
* `description` (Text): Biểu hiện quan sát được.


* `is_critical` (Boolean): Đánh dấu chỉ báo này là bắt buộc (Critical fail) hay không.

**Bảng 7: `baseline_evidence_rules` (Quy định Minh chứng Cơ sở)**
Liệt kê các loại minh chứng hợp lệ được chấp nhận cho tiêu chí này ở mức gốc (Global level).

* `id` (UUID, Primary)
* `criterion_id` (UUID, Foreign Key $\rightarrow$ `criteria.id`)
* `evidence_type` (Enum/String): Loại minh chứng (VD: `product`, `certificate`, `log`, `360_review`).


* `description` (String): Mô tả gợi ý (VD: `Biên bản sự cố; phân tích nguyên nhân`).



---

### 3. Đánh giá tính kết nối và đáp ứng nghiệp vụ của thiết kế

1. **Quản trị "Chưa đủ dữ liệu" (Mức 0):** Bằng cách cho phép `level_value = 0` trong bảng `proficiency_levels`, hệ thống giải quyết triệt để yêu cầu: "Trạng thái 'chưa đủ dữ liệu' không được quy đổi thành mức năng lực thấp". Khi Rules Engine quét thấy điểm là `0`, nó sẽ trigger trạng thái `CHƯA ĐỦ DỮ LIỆU` thay vì `KÉM`.


2. **Khả năng truy xuất của Sáng chế (Immutability):** Khi Bảng `twin_snapshots` (Bản sao số) lưu kết quả đánh giá, nó lưu mảng tham chiếu `input_references` chứa trực tiếp các `id` của bảng `indicators` và `competency_frameworks`. Nếu quản trị viên (THUCHOCVN) muốn thay đổi một "Chỉ báo" ở Bảng 6, họ phải tạo một `framework_id` mới ở Bảng 1, từ đó clone toàn bộ cây dữ liệu xuống. Các kết quả cũ trong quá khứ vẫn Join (kết nối) đúng về `indicator_id` của framework version cũ, giữ nguyên vẹn lịch sử bằng chứng theo thời gian.


3. **Tối ưu tốc độ CSDL Relational:** Cấu trúc 7 bảng này biến từ điển năng lực thành một cây thư mục chuẩn SQL. Khi chuyên gia đánh giá mở một hồ sơ, hệ thống chỉ cần dùng `Eager Loading` trong Laravel (`Competency::with('levels.criteria.indicators')->find($id)`) để kéo toàn bộ cây tiêu chí lên giao diện một cách mượt mà và tiết kiệm RAM tối đa.
-------------------------------------------------------------------------------
Dựa trên Bản mô tả sáng chế hệ thống xử lý dữ liệu, Đặc tả kỹ thuật MVP v0.1 (Yêu cầu CF-03, CF-04, BR-06) và Khung năng lực TCF v1.0, **Phân hệ Phiên bản & Quy tắc (Versioning & Rules)** chính là "bộ não" điều phối thuật toán của Động cơ Bản sao số (Twin Engine).

Phân hệ này giải quyết một vấn đề cốt lõi của sáng chế: Khi quy tắc tính điểm hoặc trọng số thay đổi, hệ thống không được tính toán lại toàn bộ, mà chỉ duyệt đồ thị phụ thuộc để tính toán lại các nút bị ảnh hưởng. Đồng thời, tuyệt đối không ghi đè lịch sử (Immutability).

Dưới đây là phân tích ngữ cảnh chi tiết và thiết kế CSDL (loại bỏ hoàn toàn JSON bằng cách chuẩn hóa các tham số thành bảng quan hệ).

### 1. Phân tích ngữ cảnh chi tiết cho Phân hệ Quy tắc & Phiên bản

* **Khái niệm "Họ quy tắc" (Rule Families) và "Phiên bản quy tắc" (Rule Versions):** Theo sáng chế, các phiên bản quy tắc xử lý có chung một mục đích sẽ được gộp vào một "Họ quy tắc" có mã định danh ổn định. Khi nội dung hoặc công thức thay đổi, hệ thống tạo một "Phiên bản quy tắc" mới thay vì ghi đè bản cũ (tuân thủ nguyên tắc BR-06).


* **"Bản ghi ánh xạ" (Mapping Record):** Đây là thực thể trung tâm của sáng chế, đóng vai trò cầu nối. Một bản ghi ánh xạ không chỉ nối "Minh chứng" với "Năng lực" mà còn chốt cứng "Phiên bản quy tắc" và "Phiên bản từ điển" tại thời điểm đánh giá đó.


* **Xử lý tham số động mà không dùng JSON:** Sáng chế đưa ra công thức ví dụ $V = \sum(e \times w \times q_i) / \sum(W \times c_i \times q_i)$. Các biến số như $w$ (trọng số), $c$ (độ tin cậy của ánh xạ) là các "tham số ánh xạ". Để không dùng cột JSON lưu mảng các biến số này, ta phải tách chúng thành một bảng `parameters` độc lập chứa các cặp key-value dạng số học.



---

### 2. Thiết kế Cơ sở dữ liệu (Database Schema)

Sử dụng khóa chính dạng ULID/UUID v7 (thay UUID v4 truyền thống — xem khuyến nghị hiệu chỉnh hiệu năng tại phân hệ Đồ thị phụ thuộc, Mục 4), tích hợp `timestamps()` và `softDeletes()` cho tất cả các bảng.

#### Nhóm 2.1: Quản lý Họ và Phiên bản Quy tắc (Rule Core)

**Bảng 1: `scoring_rule_families` (Họ quy tắc xử lý)**
Lưu trữ mã định danh ổn định để đồ thị phụ thuộc (dependency graph) dễ dàng nhận diện khi có phiên bản mới ra đời.

* `id` (UUID, Primary)
* `code` (String, Unique): Mã họ quy tắc (VD: `RULE-AVG-WEIGHTED`).
* `name` (String): Tên quy tắc (VD: "Tính trung bình có trọng số").
* `description` (String, Nullable).

**Bảng 2: `scoring_rule_versions` (Phiên bản Quy tắc - Bất biến)**
Lưu trữ công thức tính toán tại một thời điểm cụ thể.

* `id` (UUID, Primary)
* `rule_family_id` (UUID, Foreign Key $\rightarrow$ `scoring_rule_families.id`)
* `version_number` (String): Số phiên bản (VD: `v1.0`, `v1.1`).


* `rule_expression` (Text): Chuỗi công thức toán học/logic để Rules Engine thực thi (VD: `(e * w * q) / (W * c * q)`).
* `status` (Enum/String): `draft`, `review`, `active`, `retired`.


* `effective_from` (Datetime): Thời điểm hiệu lực.


* `effective_to` (Datetime, Nullable).

**Bảng 3: `rule_version_definitions` (Định nghĩa biến số của Quy tắc)**
*Thay vì lưu một mảng JSON định nghĩa cấu hình biến, ta dùng bảng con để liệt kê.*

* `id` (UUID, Primary)
* `rule_version_id` (UUID, Foreign Key $\rightarrow$ `scoring_rule_versions.id`)
* `variable_code` (String): Tên biến trong công thức (VD: `w`, `c`, `q_i`).


* `variable_name` (String): Giải thích biến (VD: "Trọng số ánh xạ", "Độ tin cậy minh chứng").


* `data_type` (Enum): `integer`, `decimal`, `boolean`.
* `is_required` (Boolean): Bắt buộc phải có giá trị truyền vào hay không.

#### Nhóm 2.2: Bản ghi Ánh xạ (The Mapping Record - Core Patent)

Theo đúng mô tả kỹ thuật của sáng chế, đây là bảng nối tất cả các dữ liệu đầu vào trước khi tính toán ra trạng thái ứng viên.

**Bảng 4: `evidence_mappings` (Bản ghi ánh xạ cốt lõi)**

* `id` (UUID, Primary)
* `person_id` (UUID, Foreign Key): Mã định danh chủ thể.


* `evidence_id` (UUID, Foreign Key): Mã định danh dữ liệu minh chứng.


* `competency_id` (UUID, Foreign Key): Mã định danh thành phần năng lực (Từ module Cấu trúc năng lực CFM).


* `rule_family_id` (UUID, Foreign Key $\rightarrow$ `scoring_rule_families.id`): Mã định danh họ quy tắc xử lý.


* `rule_version_id` (UUID, Foreign Key $\rightarrow$ `scoring_rule_versions.id`): Phiên bản quy tắc xử lý được chốt tại thời điểm này.


* `framework_version_id` (UUID, Foreign Key): Phiên bản từ điển năng lực.


* `status` (Enum/String): `active`, `superseded` (bị thay thế), `retired`.

**Bảng 5: `evidence_mapping_params` (Tham số Ánh xạ chi tiết)**
*Loại bỏ hoàn toàn JSON khi lưu các trọng số và hệ số cụ thể cho từng phép ánh xạ.*

* `id` (UUID, Primary)
* `mapping_id` (UUID, Foreign Key $\rightarrow$ `evidence_mappings.id`)
* `rule_variable_code` (String): Mã biến số (Gọi từ bảng 3, VD: `w`, `c`).


* `param_value` (Decimal, 10, 4): Giá trị thực tế áp dụng (VD: Trọng số bằng `1.5`, hệ số tin cậy bằng `1.0`).



---

### 3. Đánh giá luồng dữ liệu (Data Flow) và Khả năng vận hành

1. **Hiện thực hóa Sáng chế (Local Recalculation):** Cấu trúc bảng `evidence_mappings` chứa đầy đủ các mã định danh của Chủ thể, Minh chứng, Năng lực, Quy tắc và Từ điển. Khi Quản trị viên ban hành một `scoring_rule_versions` mới (Bảng 2), module Quản lý Quan hệ Phụ thuộc (Dependency Graph) sẽ thực hiện một câu lệnh `SELECT` đơn giản trên Bảng 4 để tìm ra ngay lập tức các `person_id` và `competency_id` nào đang sử dụng phiên bản quy tắc cũ. Hệ thống đưa các nút này vào "Tập nút trạng thái logic bị ảnh hưởng" và chỉ tính toán lại cục bộ cho các nút đó.


2. **Khả năng truy xuất nguyên vẹn (Traceability):** Khi một trạng thái Bản sao số (T_n) được lưu, nó dựa hoàn toàn vào Bảng 4 (`evidence_mappings`). Nhờ việc tách tham số ra bảng `evidence_mapping_params` (Bảng 5) dưới dạng decimal nguyên thủy thay vì nhồi vào JSON, thuật toán sinh "Dấu vân tay dữ liệu" (Hash) có thể chuẩn hóa các trường này (sort theo alphabet các keys) một cách cực kỳ ổn định, đảm bảo phát hiện chính xác sự thay đổi dù là nhỏ nhất.


3. **Hỗ trợ đa dạng phương pháp đánh giá:** Vì `rule_expression` (Bảng 2) được thiết kế mở dưới dạng chuỗi toán học, hệ thống dễ dàng cấu hình cho nhiều phương pháp đánh giá (trung bình có trọng số, đánh giá 360 độ, hoặc chuyên gia quyết định) tùy theo cấu hình của từng doanh nghiệp ở lớp Role Profile mà không cần lập trình viên can thiệp vào Source code của Rules Engine.

-------------------------------------------------------------------------------
Dựa trên các tài liệu Đặc tả MVP v0.1 (Yêu cầu EV-02, EV-03, EV-04, SEC-05), Khái niệm "Nguồn gốc dữ liệu" trong Bản mô tả sáng chế, và Lớp 1 (Thu thập dữ liệu) trong Kiến trúc 5 lớp, **Phân hệ Thu thập (Intake)** đóng vai trò là "Cửa ngõ an ninh và định danh" của toàn bộ hệ thống Bản sao số năng lực.

Để tuân thủ yêu cầu **KHÔNG sử dụng JSON** (đảm bảo tốc độ truy vấn, kiểm soát toàn vẹn dữ liệu) và tích hợp chặt chẽ với cơ chế "Đồ thị phụ thuộc" của sáng chế, dữ liệu tiếp nhận phải được bóc tách thành các bảng quan hệ (Normalized Tables) cực kỳ chi tiết.

Dưới đây là phân tích ngữ cảnh và thiết kế CSDL chi tiết cho Phân hệ Thu thập (Intake):

### 1. Phân tích ngữ cảnh chi tiết cho Phân hệ Thu thập

* **Tính đa nguồn và Nguồn gốc (Provenance):** Minh chứng không chỉ do người dùng tự tải lên, mà có thể đến từ hệ thống LMS của cơ sở đào tạo, hệ thống ERP của doanh nghiệp, hoặc kết quả khảo sát. Phân hệ phải ghi nhận chính xác nguồn cung cấp để phục vụ đánh giá mức độ tin cậy (C1-C3) sau này.


* **Bảo mật ngay từ cửa ngõ (Privacy & Security by Design):** Yêu cầu SEC-05 quy định mọi tệp tải lên phải được kiểm tra MIME type thực sự (magic bytes), quét mã độc và giới hạn dung lượng.


* **Dấu vân tay dữ liệu (Checksum) làm lõi kích hoạt:** Sáng chế yêu cầu tạo "dấu vân tay dữ liệu" (VD: SHA-256) cho mỗi minh chứng. Mã băm này là bất biến. Nếu một tệp bị thay thế, mã băm mới sinh ra sẽ kích hoạt "Đồ thị phụ thuộc" để hệ thống tính toán lại Bản sao số (sinh ra phiên bản T_n mới).


* **Vòng đời trạng thái tiếp nhận:** Dữ liệu khi mới vào sẽ trải qua các bước: `mới tiếp nhận` $\rightarrow$ `chưa kiểm tra` $\rightarrow$ `kiểm tra định dạng` trước khi chuyển sang Module Workflow để xác minh.



---

### 2. Thiết kế Cơ sở dữ liệu (Database Schema)

Sử dụng khóa chính dạng ULID/UUID v7 (thay UUID v4 truyền thống — xem khuyến nghị hiệu chỉnh hiệu năng tại phân hệ Đồ thị phụ thuộc, Mục 4), tích hợp `timestamps()` và `softDeletes()` cho tất cả các bảng.

#### Nhóm 2.1: Quản lý Nguồn gốc (The Provenance)

**Bảng 1: `evidence_sources` (Nguồn gốc minh chứng)**
Bảng này giải quyết yêu cầu EV-03, lưu vết ai hoặc hệ thống nào đã cung cấp minh chứng này.

* `id` (UUID, Primary)
* `source_category` (Enum/String): Phân loại nguồn (VD: `self_declared` - cá nhân tự khai, `organization_provided` - tổ chức cấp, `system_generated` - hệ thống sinh ra từ bài test).


* `provider_org_id` (UUID, Nullable, Foreign Key $\rightarrow$ `organizations.id`): Tổ chức cung cấp (nếu có).
* `provider_person_id` (UUID, Nullable, Foreign Key $\rightarrow$ `persons.id`): Người xác nhận/người tải lên.


* `external_reference_id` (String, Nullable): Mã ID đối soát nếu dữ liệu được đẩy qua API từ hệ thống khác (VD: mã chứng chỉ trên hệ thống nội bộ).

#### Nhóm 2.2: Dữ liệu Minh chứng Cốt lõi (The Logical Evidence)

**Bảng 2: `evidences` (Minh chứng logic)**
Đây là bảng cốt lõi đại diện cho một "bộ" minh chứng. Một minh chứng logic có thể kèm theo nhiều file vật lý.

* `id` (UUID, Primary)
* `person_id` (UUID, Foreign Key $\rightarrow$ `persons.id`): Mã định danh nội bộ của chủ thể sở hữu minh chứng này.


* `evidence_source_id` (UUID, Foreign Key $\rightarrow$ `evidence_sources.id`)
* `title` (String): Tên minh chứng (VD: "Báo cáo kiểm soát chất lượng tháng 7", "Chứng chỉ ISO 22000").


* `evidence_category` (String): Phân loại (VD: `certificate`, `work_product`, `performance_log`).


* `intake_status` (Enum/String): Trạng thái tiếp nhận đầu vào (`received`, `unchecked`, `format_checked`, `quarantined`, `rejected_malware`). (Lưu ý: Trạng thái *xác minh nghiệp vụ* sẽ nằm ở bảng khác do Module Review đảm nhiệm để tách bạch logic).


* `received_at` (Datetime): Thời điểm hệ thống nhận được dữ liệu.


* `effective_from` (Datetime, Nullable): Ngày bắt đầu có hiệu lực của minh chứng.


* `effective_to` (Datetime, Nullable): Ngày hết hiệu lực (nếu có).



#### Nhóm 2.3: Tệp Vật lý và Dấu vân tay (The Physical Files & Fingerprints)

**Bảng 3: `evidence_files` (Chi tiết tệp đính kèm)**
Thay vì lưu JSON array đường dẫn file, ta tách thành bảng con để quản lý bảo mật và Checksum cho từng file độc lập.

* `id` (UUID, Primary)
* `evidence_id` (UUID, Foreign Key $\rightarrow$ `evidences.id`)
* `original_file_name` (String): Tên gốc của tệp.
* `storage_disk` (String): Nơi lưu trữ (VD: `local_quarantine` khi mới tải lên, chuyển sang `s3_secure` khi đã quét an toàn).


* `file_path` (String): Đường dẫn mã hóa trên Storage.
* `mime_type` (String): Định dạng thực tế sau khi kiểm tra Magic Bytes (VD: `application/pdf`).


* `file_size_bytes` (Integer): Dung lượng tệp.
* `checksum` (String): Mã băm SHA-256. Đây là **Dấu vân tay dữ liệu** cực kỳ quan trọng phục vụ đối soát và tính toán Bản sao số.



#### Nhóm 2.4: Nhật ký Bảo mật đầu vào (The Security Scans)

**Bảng 4: `evidence_security_scans` (Nhật ký quét mã độc)**
Giải quyết yêu cầu SEC-05. Không dùng JSON để lưu log quét file, mà chuẩn hóa thành bảng để dễ dàng thống kê và cảnh báo an ninh.

* `id` (UUID, Primary)
* `evidence_file_id` (UUID, Foreign Key $\rightarrow$ `evidence_files.id`)
* `scan_provider` (String): Engine thực hiện quét (VD: `ClamAV`, `AWS_GuardDuty`).
* `scan_result` (Enum/String): `clean` (sạch), `infected` (nhiễm độc), `error` (lỗi quét).


* `threat_signature` (String, Nullable): Tên loại mã độc nếu phát hiện `infected`.
* `scanned_at` (Datetime): Thời điểm quét.

---

### 3. Đánh giá luồng xử lý (Data Flow) và Giá trị của Thiết kế

1. **Cơ chế Cách ly an toàn (Quarantine Workflow):** Khi người dùng tải file lên, một bản ghi được tạo ở `evidence_files` với `storage_disk = local_quarantine`. Laravel Job chạy nền sẽ quét file và ghi kết quả vào `evidence_security_scans`. Nếu `scan_result = clean`, file được move sang `s3_secure` và `intake_status` của Bảng 2 chuyển thành `format_checked`. Nếu `infected`, file bị xóa cứng lập tức, trạng thái chuyển `rejected_malware`. Điều này bảo vệ hệ thống tuyệt đối khỏi các cuộc tấn công upload.


2. **Kích hoạt Sáng chế (Triggering the Patent Engine):** Cột `checksum` trong bảng `evidence_files` là chìa khóa. Nếu một người dùng có ý đồ thay thế tệp chứng chỉ bằng một bản giả mạo, mã `checksum` sẽ thay đổi. Module Quản lý Quan hệ Phụ thuộc sẽ bắt được sự kiện (Event) này thông qua Eloquent Observer, đưa mã định danh của `evidences.id` vào đồ thị để yêu cầu vô hiệu hóa trạng thái T0 cũ và tính toán lại Bản sao số mới.


3. **Hỗ trợ Phân quyền (ABAC):** Nhờ việc lưu `person_id` ở bảng `evidences` và tách `file_path` ở bảng `evidence_files`, hệ thống dễ dàng áp dụng Laravel Policy. Chỉ khi người request có quyền xem (thông qua bảng `share_grants` đã thiết kế ở Phân hệ Tài khoản), controller mới generate một Private Signed URL có thời hạn cho `file_path` đó.

-------------------------------------------------------------------------------
Dựa trên các tài liệu Đặc tả kỹ thuật MVP v0.1 (Yêu cầu EV-04, EV-06, BR-03), Khung năng lực TCF v1.0 (Quy định về thẩm quyền xác nhận) và Cơ chế lan truyền ảnh hưởng của Sáng chế, **Phân hệ Workflow Minh chứng (Evidence Verification & Workflow)** là bộ máy vận hành trạng thái nghiệp vụ của dữ liệu.

Nếu Phân hệ Intake (Thu thập) đóng vai trò kiểm tra tính hợp lệ về mặt kỹ thuật (file an toàn, không có mã độc, đúng định dạng), thì Phân hệ Workflow sẽ giải quyết tính hợp lệ về mặt **Nghiệp vụ**: Minh chứng này có thật không? Ai xác nhận? Còn hạn sử dụng không? Có cần bổ sung thông tin không?

Để tuân thủ yêu cầu **KHÔNG sử dụng JSON**, mọi lịch sử thay đổi trạng thái và các luồng trao đổi (comments/requests) đều phải được tách thành các bảng quan hệ (Normalized Tables).

Dưới đây là phân tích ngữ cảnh và thiết kế CSDL chi tiết cho Phân hệ Workflow Minh chứng:

### 1. Phân tích ngữ cảnh chi tiết

* **Tách bạch Trạng thái File và Trạng thái Nghiệp vụ:** Một file tải lên có thể an toàn (intake: `format_checked`), nhưng về mặt nghiệp vụ nó có thể là đồ giả hoặc đã hết hạn (workflow: `rejected` hoặc `expired`).


* **Vòng đời nghiệp vụ phức tạp (EV-04):** Minh chứng phải đi qua các trạng thái: `chờ xác minh` $\rightarrow$ `xác minh toàn phần` / `xác minh một phần` / `từ chối` $\rightarrow$ `hết hiệu lực` / `thu hồi` / `lưu trữ`.


* **Truy vết tuyệt đối (Audit Trail):** Mọi sự thay đổi trạng thái bắt buộc phải lưu lại: Ai làm, làm lúc nào, từ trạng thái nào sang trạng thái nào, và lý do là gì.


* **Tương tác hai chiều (EV-06):** Hệ thống không chỉ có nút "Duyệt/Từ chối" mà phải cho phép Chuyên gia gửi "Yêu cầu bổ sung/làm rõ" lại cho Cá nhân, và Cá nhân có thể phản hồi lại. Luồng trao đổi này phải có trạng thái (open/resolved).


* **Điểm kích hoạt Sáng chế:** Sự thay đổi trạng thái ở phân hệ này (ví dụ: từ `chờ xác minh` sang `đã xác minh` hoặc bị `thu hồi`) chính là sự kiện (Event) kích hoạt Động cơ Bản sao số tính toán lại trạng thái T_n.



---

### 2. Thiết kế Cơ sở dữ liệu (Database Schema)

Sử dụng khóa chính dạng ULID/UUID v7 (thay UUID v4 truyền thống — xem khuyến nghị hiệu chỉnh hiệu năng tại phân hệ Đồ thị phụ thuộc, Mục 4), có `timestamps()` và `softDeletes()` cho mọi bảng. Dữ liệu liên kết trực tiếp với bảng `evidences` đã tạo ở Phân hệ Thu thập (Intake).

#### Nhóm 2.1: Quản lý Xác minh Nghiệp vụ (The Verification)

**Bảng 1: `evidence_verifications` (Hồ sơ kết quả xác minh)**
Bảng này lưu trữ trạng thái nghiệp vụ hiện tại và kết quả thẩm định của một minh chứng.

* `id` (UUID, Primary)
* `evidence_id` (UUID, Foreign Key $\rightarrow$ `evidences.id`): Liên kết với minh chứng gốc.
* `verifier_person_id` (UUID, Nullable, Foreign Key $\rightarrow$ `persons.id`): Chuyên gia/Người quản lý thực hiện xác minh.


* `verification_method` (Enum/String): Phương pháp xác minh (VD: `manual_review` - người duyệt, `system_auto` - hệ thống tự duyệt qua API của bên thứ 3, `ai_assisted` - AI hỗ trợ gợi ý).


* `verification_status` (Enum/String): `pending` (chờ xác minh), `verified` (xác minh toàn phần), `partially_verified` (xác minh một phần), `rejected` (từ chối), `revoked` (bị thu hồi do phát hiện sai phạm sau này).


* `verified_at` (Datetime, Nullable): Thời điểm chốt kết quả xác minh.
* `expiry_date` (Date, Nullable): Ngày minh chứng này hết hạn nghiệp vụ (VD: Chứng chỉ TOEIC hết hạn sau 2 năm).


* `internal_notes` (Text, Nullable): Ghi chú nội bộ của người chấm (người dùng không nhìn thấy).

#### Nhóm 2.2: Nhật ký Chuyển trạng thái (The State Machine Log)

**Bảng 2: `evidence_state_transitions` (Nhật ký chuyển trạng thái minh chứng)**
*Thay vì lưu một cục JSON history, ta thiết kế bảng log chuẩn để truy vấn lịch sử nhanh chóng, đáp ứng yêu cầu EV-04 và SEC-06 (Append-only audit log)*.

* `id` (UUID, Primary)
* `evidence_id` (UUID, Foreign Key $\rightarrow$ `evidences.id`)
* `from_status` (String): Trạng thái cũ (VD: `pending`).
* `to_status` (String): Trạng thái mới (VD: `verified`).


* `transitioned_by` (UUID, Foreign Key $\rightarrow$ `users.id`): User thực hiện hành động.


* `transition_reason` (String): Lý do chuyển trạng thái (Bắt buộc phải nhập khi Reject hoặc Revoke).


* `transitioned_at` (Datetime): Thời điểm thực hiện (Mặc định là thời gian tạo record).

#### Nhóm 2.3: Xử lý sự cố và Tương tác (Issue & Clarification Workflow)

Bảng này giải quyết yêu cầu EV-06: Quản lý trao đổi, yêu cầu bổ sung/sửa chữa.

**Bảng 3: `evidence_clarification_requests` (Phiếu yêu cầu làm rõ/Bổ sung)**

* `id` (UUID, Primary)
* `evidence_id` (UUID, Foreign Key $\rightarrow$ `evidences.id`)
* `requester_id` (UUID, Foreign Key $\rightarrow$ `persons.id`): Người yêu cầu (thường là Chuyên gia đánh giá).
* `request_type` (Enum/String): `missing_file` (thiếu tài liệu đính kèm), `unreadable` (ảnh mờ/không đọc được), `need_more_context` (cần giải thích thêm bối cảnh công việc).


* `title` (String): Tiêu đề yêu cầu.
* `status` (Enum/String): `open` (đang chờ phản hồi), `answered` (đã có câu trả lời), `resolved` (đã xử lý xong), `closed` (đóng).


* `due_date` (Datetime, Nullable): Hạn chót để cá nhân phải phản hồi.

**Bảng 4: `evidence_clarification_replies` (Chi tiết nội dung trao đổi)**
*Không dùng JSON array để lưu các comments, tách thành bảng 1-N để quản lý tin nhắn như một mini-chat/ticket system.*

* `id` (UUID, Primary)
* `request_id` (UUID, Foreign Key $\rightarrow$ `evidence_clarification_requests.id`)
* `sender_id` (UUID, Foreign Key $\rightarrow$ `persons.id`): Người gửi tin nhắn (có thể là Chuyên gia hoặc Cá nhân).


* `content` (Text): Nội dung trao đổi, giải trình.


* `attached_evidence_file_id` (UUID, Nullable, Foreign Key $\rightarrow$ `evidence_files.id`): Nếu cá nhân upload file bổ sung, link thẳng file mới vào đây.


* `sent_at` (Datetime).

---

### 3. Đánh giá khả năng vận hành của Thiết kế

1. **Giao tiếp hoàn hảo với Động cơ Bản sao số (Sáng chế):** Theo sáng chế, hệ thống chỉ chọn các dữ liệu minh chứng "đáp ứng điều kiện về trạng thái xác minh, khoảng thời gian hiệu lực" để đưa vào tính toán T_n. Thiết kế Bảng `evidence_verifications` cung cấp chính xác 2 thông số này (`verification_status` = `verified` và `expiry_date` >= `now()`). Bất cứ khi nào Bảng 2 (`evidence_state_transitions`) nhận một bản ghi mới làm thay đổi 2 yếu tố này, hệ thống sẽ kích hoạt tính toán lại đồ thị.


2. **Bảo vệ tính toàn vẹn (Anti-Tampering):** Thiết kế bảng `evidence_state_transitions` theo nguyên tắc `Append-Only` (Chỉ thêm mới, không sửa/xóa). Điều này giúp hệ thống truy vết chính xác ai đã duyệt sai quy trình hoặc ai đã cố tình `revoke` một minh chứng hợp lệ, đáp ứng tiêu chuẩn Audit của hệ thống nhân sự cấp cao.


3. **Tách bạch logic hiển thị (Decoupling):** Quá trình tranh luận giữa Chuyên gia và Cá nhân (Bảng 3, 4) diễn ra song song nhưng độc lập với trạng thái tổng của minh chứng. Một minh chứng có thể đang `pending`, bên trong có 2 tickets `open` yêu cầu làm rõ. Khi các tickets này `resolved`, Chuyên gia mới thực hiện chuyển trạng thái ở Bảng 1 sang `verified`. Việc này giúp UI/UX của hệ thống rất mượt mà, giống như một hệ thống quản lý công việc (Jira/Trello) thu nhỏ dành riêng cho việc xét duyệt hồ sơ.
-------------------------------------------------------------------------------
Dựa trên Đặc tả kỹ thuật MVP v0.1 (Yêu cầu EV-05, BR-03, AI-02), Khung năng lực TCF v1.0 và đặc biệt là cơ chế lõi của Bản mô tả sáng chế, **Phân hệ Ánh xạ (Mapping)** là cây cầu nối mang tính quyết định giữa dữ liệu thô (Phân hệ Intake/Workflow) và khung chuẩn (Phân hệ Cấu trúc năng lực).

Nhiệm vụ của phân hệ này là trả lời câu hỏi: *"Minh chứng vật lý này chứng minh cho tiêu chí năng lực nào, ở mức độ liên quan bao nhiêu, và ai/hệ thống nào đã đưa ra nhận định đó?"*

Để đáp ứng yêu cầu **KHÔNG sử dụng JSON**, phục vụ truy vấn tốc độ cao cho đồ thị lan truyền ảnh hưởng của Sáng chế, dữ liệu ánh xạ phải được chuẩn hóa hoàn toàn (Fully Normalized). Dưới đây là phân tích và thiết kế chi tiết:

### 1. Phân tích ngữ cảnh chi tiết cho Phân hệ Ánh xạ

* **Quan hệ Nhiều - Nhiều (Many-to-Many):** Yêu cầu EV-05 chỉ rõ một minh chứng có thể hỗ trợ đánh giá nhiều tiêu chí (Ví dụ: Một "Báo cáo cải tiến" vừa chứng minh cho năng lực Giải quyết vấn đề WSE-02, vừa chứng minh cho năng lực Ứng dụng công cụ số DIG-01). Ngược lại, một tiêu chí cũng cần nhiều minh chứng gộp lại mới đủ độ tin cậy.


* **Tách bạch Độ tin cậy (Confidence) và Mức liên quan (Relevance):** Theo quy tắc BR-03, một chứng chỉ giả mạo có thể bị "từ chối xác minh" (Workflow reject), trong khi một chứng chỉ thật (Verified) lại có thể "liên quan rất thấp" (Relevance = Low) đến vị trí việc làm hiện tại. Phân hệ Ánh xạ chỉ quan tâm đến *Mức độ liên quan* và *Độ tin cậy của phép ánh xạ đó*.


* **Luồng AI gợi ý và Con người kiểm soát (AI-02 & Human-in-the-loop):** AI (LLM) sẽ đọc file minh chứng, dò trong CSDL Tiêu chí/Chỉ báo và đưa ra gợi ý: *"Nên ánh xạ file này vào Tiêu chí X, vì lý do Y"*. Các gợi ý này không được phép ghi thẳng vào hồ sơ chính thức mà phải nằm ở bảng trung gian, chờ Chuyên gia hoặc Cá nhân duyệt (Chấp nhận/Chỉnh sửa/Từ chối).


* **Liên kết chặt chẽ với Sáng chế (Bản ghi ánh xạ):** Bản ghi ánh xạ trong sáng chế yêu cầu lưu trữ rõ mã định danh chủ thể, minh chứng, thành phần năng lực và phiên bản từ điển áp dụng để khi có thay đổi, hệ thống biết chính xác phải tính toán lại nút trạng thái nào.



---

### 2. Thiết kế Cơ sở dữ liệu (Database Schema)

Sử dụng khóa chính dạng ULID/UUID v7 (thay UUID v4 truyền thống — xem khuyến nghị hiệu chỉnh hiệu năng tại phân hệ Đồ thị phụ thuộc, Mục 4), tích hợp `timestamps()` và `softDeletes()` để bảo toàn lịch sử.

#### Nhóm 2.1: Bản ghi Ánh xạ Tác nghiệp (The Operational Mapping)

**Bảng 1: `evidence_criterion_mappings` (Bản ghi Ánh xạ cốt lõi)**
Bảng này nối trực tiếp Minh chứng (từ Phân hệ Intake) với Tiêu chí (từ Phân hệ Cấu trúc năng lực CFM), đáp ứng yêu cầu EV-05.

* `id` (UUID, Primary)
* `evidence_id` (UUID, Foreign Key $\rightarrow$ `evidences.id`)


* `criterion_id` (UUID, Foreign Key $\rightarrow$ `criteria.id`): Trỏ trực tiếp đến Tiêu chí cụ thể thuộc một phiên bản Khung năng lực bất biến.


* `person_id` (UUID, Foreign Key $\rightarrow$ `persons.id`): Phục vụ việc phân quyền xem và duyệt (ABAC).


* `relevance_score` (Integer): Mức độ liên quan của minh chứng với tiêu chí (VD: Thang 1-5).


* `confidence_score` (Integer): Độ tin cậy của riêng phép ánh xạ này (Khác với độ tin cậy của file).


* `status` (Enum/String): `pending_review` (chờ duyệt), `active` (đã duyệt, có hiệu lực tính điểm), `rejected` (bác bỏ), `superseded` (bị thay thế).


* `mapping_source` (Enum/String): `manual_user` (người dùng tự map), `manual_expert` (chuyên gia map), `ai_suggested` (AI đề xuất).



#### Nhóm 2.2: Dấu vết của AI và Gợi ý (AI Suggestions Traceability)

Để không dùng JSON lưu các output của AI (như lý do, mức độ tự tin của model), ta chuẩn hóa thành bảng riêng để truy vấn và đo lường tỷ lệ chính xác của AI (Use case AI-02).

**Bảng 2: `ai_mapping_suggestions` (Chi tiết Gợi ý Ánh xạ của AI)**

* `id` (UUID, Primary)
* `mapping_id` (UUID, Foreign Key $\rightarrow$ `evidence_criterion_mappings.id`)
* `ai_model_version` (String): Model đã dùng (VD: `gpt-4o-2026-08`, `claude-3-opus`).


* `ai_confidence_level` (Decimal): Độ tự tin do model trả về (VD: `0.85` $\sim$ 85%).
* `reasoning_text` (Text): Lý do AI đề xuất ánh xạ này (Trích xuất từ kết quả Prompt).


* `suggested_at` (Datetime).

#### Nhóm 2.3: Sự phê duyệt của Con người (Human-in-the-loop Reviews)

**Bảng 3: `mapping_human_reviews` (Hồ sơ Phê duyệt Ánh xạ)**
Bảng này ghi vết quyết định của con người đối với các ánh xạ (đặc biệt là ánh xạ do AI đề xuất), đáp ứng nguyên tắc "Con người chịu trách nhiệm cuối cùng".

* `id` (UUID, Primary)
* `mapping_id` (UUID, Foreign Key $\rightarrow$ `evidence_criterion_mappings.id`)
* `reviewer_person_id` (UUID, Foreign Key $\rightarrow$ `persons.id`): ID của chuyên gia hoặc người quản lý duyệt.
* `review_decision` (Enum/String): `accepted` (chấp nhận gợi ý), `edited` (chỉnh sửa lại relevance_score), `rejected` (đánh giá AI map sai).


* `reviewer_comments` (Text, Nullable): Nhận xét của người duyệt.
* `reviewed_at` (Datetime).

#### Nhóm 2.4: Bảng Tham chiếu Chỉ báo (Indicator Granularity)

Đôi khi một tiêu chí quá rộng, minh chứng chỉ đáp ứng được 1 trong 3 "Chỉ báo" (Indicators) của tiêu chí đó. Bảng con này giúp hệ thống đánh giá chi tiết (Granular mapping).

**Bảng 4: `mapping_indicator_details` (Ánh xạ cấp độ Chỉ báo)**

* `id` (UUID, Primary)
* `mapping_id` (UUID, Foreign Key $\rightarrow$ `evidence_criterion_mappings.id`)
* `indicator_id` (UUID, Foreign Key $\rightarrow$ `indicators.id`).


* `is_met` (Boolean): Có đáp ứng chỉ báo này hay không.

---

### 3. Đánh giá luồng dữ liệu (Data Flow) và Khả năng vận hành

1. **Hiệu năng vượt trội nhờ loại bỏ JSON:** Nếu lưu output của AI (gồm *lý do, điểm số, trạng thái duyệt*) vào một cột `ai_metadata` dạng JSON, việc thống kê "Tỷ lệ AI đoán đúng/sai theo từng Model" sẽ cực kỳ chậm chạp. Việc tách ra các bảng `ai_mapping_suggestions` và `mapping_human_reviews` giúp truy vấn bằng các hàm COUNT, GROUP BY truyền thống nhanh hơn gấp nhiều lần, phục vụ hoàn hảo cho việc đo lường KPI của công cụ AI.


2. **Kích hoạt Động cơ Bản sao số (The Patent Trigger):** Bảng `evidence_criterion_mappings` chính là "Công tắc". Bất cứ khi nào cột `status` của một dòng trong bảng này chuyển thành `active` (do Chuyên gia ấn duyệt ở bảng 3), hệ thống sẽ gọi Event. Event này nạp `person_id` và `criterion_id` (tương đương mã thành phần năng lực) vào *Cấu trúc quan hệ phụ thuộc* (Dependency Graph) của sáng chế. Hệ thống lúc này biết chính xác có một dữ liệu đầu vào mới đã sẵn sàng và sẽ bắt đầu tính toán lại trạng thái ứng viên để tạo ra phiên bản T_n mới.


3. **Toàn vẹn và Bất biến (Immutability):** Khi một minh chứng bị hết hạn, hệ thống không xóa dòng ánh xạ này. Thay vào đó, nó chuyển `status` thành `superseded` hoặc `retired`. Lịch sử đánh giá T_n trong quá khứ vẫn trỏ khóa ngoại về ID của phép ánh xạ này, đảm bảo khả năng giải trình (Traceability) tại bất kỳ thời điểm nào trong tương lai: *"Vào ngày X, điểm năng lực của nhân sự Y là M3 dựa trên minh chứng Z, do AI đề xuất và Chuyên gia K đã duyệt"*.
-------------------------------------------------------------------------------
Dựa trên các tài liệu Đặc tả kỹ thuật MVP v0.1 (Yêu cầu AS-01 đến AS-03), Khung năng lực TCF v1.0 (Quy định về nguồn đánh giá đa chiều và Thang đo M, C) và Bản mô tả sáng chế, **Phân hệ Đánh giá (Assessment Module)** là nơi hội tụ của toàn bộ dữ liệu đầu vào.

Nếu Phân hệ *Thu thập* mang rổ tài liệu về, Phân hệ *Workflow* xác nhận tài liệu là thật, Phân hệ *Ánh xạ* nối tài liệu vào tiêu chí, thì **Phân hệ Đánh giá** là nơi các tác nhân (Bản thân, Quản lý, Chuyên gia, Hệ thống) chính thức "chấm điểm" mức độ thành thạo của cá nhân dựa trên các dữ liệu đó.

Để tuân thủ yêu cầu **KHÔNG sử dụng JSON** (đặc biệt quan trọng để tránh lưu mảng các minh chứng viện dẫn vào một cột), thiết kế cơ sở dữ liệu dưới đây chia nhỏ phiếu đánh giá thành các bảng chi tiết đến từng tiêu chí (Line-item level).

### 1. Phân tích ngữ cảnh chi tiết và Luồng nghiệp vụ (Business Flow)

* **Tính đa nguồn (Multi-source/360-degree):** Hệ thống không chỉ có một người chấm. Một "Đợt đánh giá" có thể bao gồm: Cá nhân tự đánh giá, Quản lý trực tiếp đánh giá, và Chuyên gia độc lập thẩm định. Mỗi người sẽ có một "Phiếu đánh giá" riêng.


* **Viện dẫn minh chứng bắt buộc (AS-02):** Khác với các hệ thống HRM thông thường chỉ tick chọn điểm 1-5, hệ thống này bắt buộc mọi điểm số phải trỏ về "Minh chứng" hoặc phải ghi rõ "Lý do điều chỉnh" (Justification).


* **Tách bạch Điểm năng lực và Độ tin cậy (AS-03):** Người đánh giá phải xác định Mức năng lực (VD: M3) và Mức độ tin cậy của nhận định đó (VD: C2 - Trung bình do minh chứng chưa đủ mạnh).


* **Luồng giao tiếp với Động cơ Bản sao số (Twin Engine):** Kết quả từ các phiếu đánh giá ở phân hệ này CHƯA PHẢI là trạng thái Bản sao số cuối cùng. Phân hệ này chỉ cung cấp các "điểm thành phần". Sau đó, Động cơ Bản sao số (Sáng chế) sẽ lấy các điểm này, ném vào "Quy tắc tổng hợp" (Scoring Rules) để tính ra trạng thái T0, T1 bất biến.



---

### 2. Thiết kế Cơ sở dữ liệu (Database Schema)

Sử dụng khóa chính dạng ULID/UUID v7 (thay UUID v4 truyền thống — xem khuyến nghị hiệu chỉnh hiệu năng tại phân hệ Đồ thị phụ thuộc, Mục 4), tích hợp `timestamps()` và `softDeletes()`.

#### Nhóm 2.1: Quản lý Đợt và Phân công (Assessment Operations)

**Bảng 1: `assessment_cycles` (Đợt đánh giá)**
Lưu trữ thông tin về một kỳ đánh giá định kỳ hoặc đột xuất.

* `id` (UUID, Primary)
* `organization_id` (UUID, Foreign Key $\rightarrow$ `organizations.id`): Đơn vị tổ chức.
* `campaign_id` (UUID, Nullable, Foreign Key $\rightarrow$ `pilot_campaigns.id`): Nếu đợt đánh giá này thuộc một chiến dịch Pilot.


* `name` (String): Tên đợt (VD: "Đánh giá năng lực cuối năm 2026").
* `start_date` (Datetime)
* `end_date` (Datetime)
* `status` (Enum/String): `planning`, `active`, `completed`, `cancelled`.



**Bảng 2: `assessment_assignments` (Phân công đánh giá)**
Bảng này trả lời câu hỏi: "Ai đánh giá Ai, dựa trên Hồ sơ vị trí nào?".

* `id` (UUID, Primary)
* `cycle_id` (UUID, Foreign Key $\rightarrow$ `assessment_cycles.id`)
* `subject_person_id` (UUID, Foreign Key $\rightarrow$ `persons.id`): Người được đánh giá (Ứng viên/Nhân viên).
* `assessor_person_id` (UUID, Foreign Key $\rightarrow$ `persons.id`): Người thực hiện đánh giá. (Nếu là tự đánh giá thì ID này trùng với subject_person_id).
* `role_profile_id` (UUID, Foreign Key $\rightarrow$ `role_profiles.id`): Bảng tham chiếu từ module Hồ sơ vị trí, quy định bộ tiêu chí cần chấm.


* `assessment_method` (Enum/String): `self_assessment`, `manager_review`, `expert_review`, `peer_review`.


* `due_date` (Datetime): Hạn chót nộp phiếu.
* `status` (Enum/String): `pending`, `in_progress`, `submitted`, `overdue`.



#### Nhóm 2.2: Phiếu đánh giá và Kết quả chi tiết (The Assessment Form)

**Bảng 3: `assessments` (Phiếu đánh giá tổng - Header)**

* `id` (UUID, Primary)
* `assignment_id` (UUID, Foreign Key $\rightarrow$ `assessment_assignments.id`)
* `framework_version_id` (UUID, Foreign Key $\rightarrow$ `competency_frameworks.id`): Khóa chặt phiên bản từ điển năng lực tại thời điểm mở phiếu.


* `overall_comments` (Text, Nullable): Nhận xét chung của người chấm.
* `status` (Enum/String): `draft`, `submitted`, `under_review`, `completed`, `adjusted`, `voided` (Hủy bỏ).


* `submitted_at` (Datetime, Nullable).
* `approved_by_id` (UUID, Nullable): Người phê duyệt phiếu (nếu quy trình yêu cầu).



**Bảng 4: `assessment_criterion_results` (Điểm chi tiết theo từng Tiêu chí - Line Items)**
*Loại bỏ hoàn toàn JSON. Mỗi tiêu chí được chấm sẽ là một dòng trong bảng này, giúp dễ dàng tính toán thống kê (AVG, MAX, MIN)*.

* `id` (UUID, Primary)
* `assessment_id` (UUID, Foreign Key $\rightarrow$ `assessments.id`)
* `competency_id` (UUID, Foreign Key $\rightarrow$ `competencies.id`)
* `criterion_id` (UUID, Foreign Key $\rightarrow$ `criteria.id`).


* `proficiency_level_id` (UUID, Nullable, Foreign Key $\rightarrow$ `proficiency_levels.id`): Mức đạt được (M1-M5 hoặc M0-Chưa đủ dữ liệu).


* `numeric_score` (Integer, Nullable): Giá trị số học của mức (0, 1, 2, 3, 4, 5) để tiện cho Rules Engine tính toán.


* `confidence_level` (Integer): Mức độ tự tin của người chấm (VD: 1, 2, 3 tương ứng C1, C2, C3).


* `assessor_notes` (Text, Nullable): Ghi chú diễn giải của người chấm cho riêng tiêu chí này.
* `is_insufficient_data` (Boolean): Flag đánh dấu nhanh `true` nếu người chấm xác nhận là "Chưa đủ dữ liệu" thay vì đánh giá năng lực kém.



#### Nhóm 2.3: Viện dẫn Minh chứng (Evidence Referencing)

Để đáp ứng luật AS-02: *"Bắt buộc dẫn minh chứng hoặc lý do khi điều chỉnh"*, ta không dùng mảng JSON chứa các ID minh chứng. Ta dùng bảng trung gian (Many-to-Many).

**Bảng 5: `assessment_result_evidences` (Minh chứng viện dẫn cho điểm số)**

* `id` (UUID, Primary)
* `criterion_result_id` (UUID, Foreign Key $\rightarrow$ `assessment_criterion_results.id`)
* `mapping_id` (UUID, Nullable, Foreign Key $\rightarrow$ `evidence_criterion_mappings.id`): Trỏ về bản ghi Ánh xạ (Phân hệ trước) đã được dùng làm căn cứ cho điểm số này.


* `justification_reason` (Text, Nullable): Nếu không có minh chứng mà người chấm (chuyên gia) vẫn cho điểm dựa trên quan sát trực tiếp, bắt buộc phải ghi lý do vào đây (Bỏ qua `mapping_id`).



---

### 3. Logic luồng nghiệp vụ (Business Logic Flow) tích hợp toàn hệ thống

Thiết kế này tạo ra một dòng chảy nghiệp vụ (Data Pipeline) cực kỳ chặt chẽ giữa các module:

1. **Khởi tạo (CFM + IAM $\rightarrow$ Assessment):** Quản trị viên tạo Đợt đánh giá (Bảng 1). Hệ thống đọc Bảng `memberships` (Phân hệ IAM) để lấy danh sách nhân viên, đối chiếu với Bảng `role_profiles` (Phân hệ CFM) để biết nhân viên này cần làm phiếu đánh giá cho vị trí nào. Hệ thống sinh ra các bản ghi phân công ở Bảng 2.


2. **Thực hiện đánh giá (EVM + Mapping $\rightarrow$ Assessment):** Khi người chấm mở Phiếu đánh giá (Bảng 3), màn hình sẽ load danh sách các tiêu chí (Bảng 4). Tại mỗi tiêu chí, hệ thống tự động JOIN với Bảng `evidence_criterion_mappings` (Phân hệ Ánh xạ) để hiển thị sẵn: *"Hệ thống tìm thấy 3 minh chứng liên quan đến tiêu chí này, AI gợi ý mức M3"*. Người chấm xem xét, chọn mức (M1-M5), chọn mức tin cậy (C1-C3), và click chọn các minh chứng trên màn hình. Hành động click này sẽ ghi dữ liệu vào Bảng 5.


3. **Kích hoạt Sáng chế (Assessment $\rightarrow$ Twin Engine):** Khi phiếu đánh giá chuyển trạng thái `status = completed` (Bảng 3), sự kiện này được đẩy vào Đồ thị phụ thuộc (Dependency Graph).


* *Twin Engine* sẽ gom tất cả các `assessment_criterion_results` (Ví dụ: 1 điểm do Tự đánh giá, 1 điểm do Quản lý chấm, 1 điểm do Chuyên gia chấm).
* Nó nạp các điểm số này vào `scoring_rule_versions` (Quy tắc tổng hợp - Module Versioning).


* Ví dụ: Nếu quy tắc quy định "Lấy điểm của Chuyên gia làm trọng số cao nhất khi có mâu thuẫn", engine sẽ tính toán ra một điểm cuối cùng (VD: M3, độ tin cậy C2) và sinh ra **Bản sao số năng lực T_n bất biến**.

-------------------------------------------------------------------------------
Dựa trên Bản mô tả sáng chế hệ thống xử lý dữ liệu, Đặc tả kỹ thuật MVP v0.1 (Yêu cầu TW-01 đến TW-04) và Khung năng lực TCF v1.0, **Phân hệ Snapshot Bất biến (Immutable Snapshot)** nằm trong Động cơ Bản sao số (Twin Engine) chính là "trái tim" mang tính đột phá của toàn bộ dự án.

Phân hệ này hiện thực hóa yêu cầu khắt khe nhất của Sáng chế: **Duy trì chuỗi trạng thái có phiên bản không ghi đè, đảm bảo khả năng truy xuất tuyệt đối về quá khứ**. Để tuân thủ yêu cầu **KHÔNG sử dụng JSON** (đặc biệt trong việc lưu trữ danh sách các dữ liệu đầu vào `input_references` như tài liệu thiết kế sơ bộ từng đề cập), chúng ta phải chuẩn hóa (Normalize) cấu trúc này thành các bảng quan hệ chặt chẽ.

Dưới đây là phân tích ngữ cảnh chi tiết và thiết kế CSDL cho Phân hệ Snapshot Bất biến:

### 1. Phân tích ngữ cảnh chi tiết và Luồng nghiệp vụ (Business Flow)

* **Tách bạch "Nút logic" và "Phiên bản":** Theo Sáng chế, hệ thống không chỉ lưu một bảng điểm. Đối với mỗi cặp `(Chủ thể, Thành phần năng lực)`, hệ thống tạo ra một **"Nút trạng thái logic"**. Nút này giữ một con trỏ (chỉ mục) trỏ đến "Trạng thái hiện hành", và bên dưới nó là một chuỗi các **"Bản ghi trạng thái phiên bản"** (T0, T1, Tn) không bao giờ bị ghi đè.


* **Cơ chế Trạng thái Ứng viên và Dấu vân tay (Hash):** Khi có một điểm đánh giá mới (từ Phân hệ Assessment), hệ thống không tạo ngay phiên bản T_n mới. Nó tính ra một "Trạng thái ứng viên", thu thập tất cả các ID đầu vào, chuẩn hóa và băm (hash) thành một "Dấu vân tay trạng thái". Chỉ khi dấu vân tay này khác với dấu vân tay của trạng thái hiện hành, một bản ghi Snapshot mới mới được sinh ra. Điều này chống việc ghi log rác vào CSDL.


* **Bảo vệ dữ liệu thiếu (TW-01):** Nếu dữ liệu đầu vào không thỏa mãn điều kiện quy tắc, Snapshot vẫn được tạo nhưng mang mức độ thành thạo M0 (Chưa đủ dữ liệu), hệ thống không được tự động quy đổi thành mức năng lực thấp.



---

### 2. Thiết kế Cơ sở dữ liệu (Database Schema)

Sử dụng khóa chính dạng ULID/UUID v7 (thay UUID v4 truyền thống — xem khuyến nghị hiệu chỉnh hiệu năng tại phân hệ Đồ thị phụ thuộc, Mục 4), tích hợp `timestamps()` và `softDeletes()`.

#### Nhóm 2.1: Quản lý Nút Logic và Sự kiện kích hoạt (The Core Engine)

**Bảng 1: `twin_state_nodes` (Nút trạng thái logic)**
Bảng này hiện thực hóa Điểm số 1 của Sáng chế: Quản lý chỉ mục hiện hành.

* `id` (UUID, Primary)
* `person_id` (UUID, Foreign Key $\rightarrow$ `persons.id`): Mã định danh chủ thể.


* `competency_id` (UUID, Foreign Key $\rightarrow$ `competencies.id`): Mã định danh thành phần năng lực.


* `current_snapshot_id` (UUID, Nullable, Foreign Key $\rightarrow$ `twin_snapshots.id`): **Chỉ mục trạng thái hiện hành** - con trỏ luôn trỏ về phiên bản mới nhất đang có hiệu lực.


* `status` (Enum/String): `active`, `locked`.



**Bảng 2: `twin_update_events` (Sự kiện thay đổi / Kích hoạt)**
Lưu trữ nguyên nhân kích hoạt Động cơ tính toán lại.

* `id` (UUID, Primary)
* `event_type` (Enum/String): `evidence_verified`, `evidence_expired`, `assessment_completed`, `rule_changed`.


* `source_object_type` (String): Bảng gây ra sự kiện (VD: `assessments`).
* `source_object_id` (UUID): ID của đối tượng gây sự kiện.
* `processed_at` (Datetime): Thời điểm Động cơ hoàn tất việc xử lý sự kiện này.



#### Nhóm 2.2: Bản ghi Phiên bản Bất biến (The Immutable Snapshots)

**Bảng 3: `twin_snapshots` (Bản ghi trạng thái phiên bản T0...Tn)**
Bảng này tuyệt đối **KHÔNG BAO GIỜ UPDATE** các trường giá trị (Chỉ thêm mới - Append-only), đáp ứng yêu cầu TW-02 và Sáng chế.

* `id` (UUID, Primary)
* `state_node_id` (UUID, Foreign Key $\rightarrow$ `twin_state_nodes.id`)
* `predecessor_snapshot_id` (UUID, Nullable, Foreign Key $\rightarrow$ `twin_snapshots.id`): Trỏ về trạng thái liền trước (T1 trỏ về T0, T0 = null).


* `version_number` (Integer): Số thứ tự phiên bản (1, 2, 3...).


* `trigger_event_id` (UUID, Foreign Key $\rightarrow$ `twin_update_events.id`): Sự kiện sinh ra bản ghi này.


* `framework_version_id` (UUID, Foreign Key $\rightarrow$ `competency_frameworks.id`): Phiên bản từ điển năng lực tại thời điểm chốt.


* `scoring_rule_version_id` (UUID, Foreign Key $\rightarrow$ `scoring_rule_versions.id`): Công thức/Quy tắc đã dùng.


* `proficiency_level_id` (UUID, Nullable, Foreign Key $\rightarrow$ `proficiency_levels.id`): Mức đạt được (M0-M5).


* `numeric_score` (Decimal, 5, 2): Giá trị trạng thái nội bộ.


* `confidence_level` (Integer): Mức độ tin cậy tổng hợp (C1-C3).


* `snapshot_hash` (String): **Dấu vân tay trạng thái** (SHA-256) được băm từ toàn bộ các dữ liệu đầu vào.


* `approver_id` (UUID, Nullable, Foreign Key $\rightarrow$ `persons.id`): Người phê duyệt bản ghi này (nếu quy trình yêu cầu).


* `status` (Enum/String): `draft` (ứng viên), `approved` (chính thức), `restricted` (hạn chế/ẩn do yêu cầu pháp lý), `superseded` (bị thay thế bởi T_n+1).



#### Nhóm 2.3: Phân rã Dữ liệu đầu vào (Thay thế JSON Input References)

Thay vì lưu một cục JSON mảng các ID minh chứng/đánh giá như gợi ý thiết kế sơ bộ ban đầu, Sáng chế yêu cầu khả năng truy xuất ngược hai chiều. Bảng 4 dưới đây giải quyết triệt để vấn đề này.

**Bảng 4: `twin_snapshot_inputs` (Tập tham chiếu đầu vào)**
Bảng này liệt kê chính xác TỪNG bản ghi (minh chứng, kết quả đánh giá) đã được cộng gộp để ra được con số ở Bảng 3.

* `id` (UUID, Primary)
* `snapshot_id` (UUID, Foreign Key $\rightarrow$ `twin_snapshots.id`)
* `input_type` (Enum/String): Loại dữ liệu tham chiếu (VD: `assessment_criterion_result`, `evidence_mapping`).


* `reference_id` (UUID): ID của bản ghi đầu vào (VD: ID của dòng điểm chuyên gia chấm ở phân hệ Assessment).
* `contribution_weight` (Decimal, 10, 4): Trọng số của riêng đầu vào này trong lần tính toán đó (để có thể giải trình vì sao ra được điểm tổng).

---

### 3. Đánh giá luồng xử lý và Hiện thực hóa Sáng chế (Patent Implementation)

1. **Cơ chế Tính toán cục bộ và Chống lặp (Claim 1 của Sáng chế):**
* Giả sử Minh chứng `E001` bị đánh dấu là "Hết hạn" ở Phân hệ Workflow. Một sự kiện được ghi vào bảng `twin_update_events` (Bảng 2).


* Hệ thống sẽ query Bảng 4 (`twin_snapshot_inputs`) với `reference_id = E001` để tìm ra ngay lập tức `snapshot_id` nào đang phụ thuộc vào minh chứng này.
* Từ `snapshot_id`, hệ thống tìm ra `state_node_id` (Bảng 1). Hệ thống chỉ tính toán lại các "Nút trạng thái logic" này mà bỏ qua hàng vạn nút khác trong CSDL.




2. **Khả năng giải trình tuyệt đối (Explainability):**
* Khi nhân viên mở Cổng cá nhân và thắc mắc: *"Tại sao kỹ năng AIW-02 của tôi ở thời điểm T2 (tháng 8/2026) chỉ đạt M2?"*.


* Hệ thống truy vấn Bảng 3 `twin_snapshots` của thời điểm đó, JOIN với Bảng 4 `twin_snapshot_inputs`. Giao diện sẽ hiển thị rõ: *"Tại thời điểm T2, trạng thái này được tổng hợp từ Điểm tự đánh giá (M3) và Điểm chuyên gia (M1), sử dụng quy tắc tính trung bình phiên bản v1.0. Chuyên gia cho M1 vì thiếu file minh chứng X"*. Mọi thứ đều được lưu vết nguyên trạng và không thể giả mạo.




3. **Bảo vệ dữ liệu bằng Dấu vân tay (Hash Integrity):**
* Cột `snapshot_hash` trong Bảng 3 là vũ khí tối thượng của hệ thống. Thuật toán trong Laravel sẽ thực hiện: Nạp ID của Node + Nạp các `reference_id` + Nạp `scoring_rule_version_id` $\rightarrow$ Sort chuỗi $\rightarrow$ Hash SHA256. Nếu hệ thống vô tình bị trigger lặp sự kiện, thuật toán sinh ra Trạng thái Ứng viên có Hash trùng khớp với `snapshot_hash` của Trạng thái Hiện hành. Hệ thống sẽ hủy bỏ giao dịch, không tạo thêm bản ghi rác, tối ưu hiệu năng Database ở mức cao nhất.

-------------------------------------------------------------------------------
Dựa trên Bản mô tả sáng chế hệ thống xử lý dữ liệu và Đặc tả kỹ thuật MVP v0.1, **Phân hệ Đồ thị phụ thuộc (Dependency Graph)** chính là "hệ thần kinh trung ương" của toàn bộ hệ thống Bản sao số.

Sáng chế quy định rõ: Hệ thống không tính toán lại toàn bộ dữ liệu khi có thay đổi, mà phải duy trì một "cấu trúc quan hệ phụ thuộc biểu diễn quan hệ lan truyền ảnh hưởng". Khi một sự kiện xảy ra, hệ thống sẽ duyệt đồ thị này để tìm ra chính xác "tập nút trạng thái logic bị ảnh hưởng" và chỉ tính toán lại cục bộ tại các nút đó.

Để đáp ứng yêu cầu **tuyệt đối KHÔNG sử dụng JSON**, xử lý được các quan hệ phức tạp đa hình (Polymorphic) và giải quyết bài toán "phụ thuộc tuần hoàn" (chu trình lặp), dưới đây là thiết kế CSDL chuẩn hóa (Normalized) chi tiết:

### 1. Phân tích ngữ cảnh chi tiết và Luồng nghiệp vụ

* **Tính Đa hình của Đối tượng Nguồn (Polymorphic Sources):** Theo sáng chế, "đối tượng đầu vào" có thể là rất nhiều loại dữ liệu khác nhau: Dữ liệu minh chứng, Bản ghi ánh xạ, Họ quy tắc (Rule Family), Phiên bản từ điển năng lực, hoặc thậm chí là một Nút trạng thái logic khác (Năng lực cha phụ thuộc năng lực con).


* **Đối tượng Đích luôn là Nút Logic (Target):** Điểm đến của mọi mũi tên trong đồ thị luôn trỏ về `twin_state_nodes.id` (Nút trạng thái logic của một Cặp Chủ thể - Thành phần năng lực).


* **Xử lý Lan truyền và Hội tụ (Propagation & Convergence):** Khi xác định tập bị ảnh hưởng, nếu đồ thị có chu trình (vòng lặp), hệ thống phải tính toán lặp cho đến khi "dấu vân tay kết quả không còn thay đổi hoặc đạt giới hạn lặp". Do đó, ta cần các bảng quản lý "Hàng đợi tính toán" (Recalculation Queue) để lưu trạng thái của từng vòng lặp.



---

### 2. Thiết kế Cơ sở dữ liệu (Database Schema)

Sử dụng khóa chính dạng định danh toàn cục (xem khuyến nghị hiệu chỉnh **ULID/UUID v7** ở Mục 4 bên dưới thay cho UUID v4 truyền thống), tích hợp `timestamps()` và `softDeletes()`.

#### Nhóm 2.1: Các cạnh của Đồ thị (The Graph Edges)

Đây là bảng lưu trữ các "đường nối" (links) giữa các thực thể, hiện thực hóa cấu trúc lan truyền ảnh hưởng.

**Bảng 1: `dependency_links` (Liên kết lan truyền ảnh hưởng)**

* `id` (UUID, Primary)
* `source_object_type` (Enum/String): Loại đối tượng nguồn. Cấu trúc Polymorphic của Laravel. Các giá trị hợp lệ: `evidence`, `evidence_mapping`, `scoring_rule_family`, `competency_framework`, `twin_state_node`.


* `source_object_id` (UUID): ID thực tế của đối tượng nguồn tương ứng (VD: ID của một minh chứng hoặc ID của một họ quy tắc).


* `target_state_node_id` (UUID, Foreign Key $\rightarrow$ `twin_state_nodes.id`): ID của Nút trạng thái logic đích bị ảnh hưởng bởi nguồn này.


* `dependency_type` (Enum/String): Bản chất của sự phụ thuộc (VD: `data_input` - dữ liệu đầu vào, `rule_reference` - tham chiếu quy tắc, `rollup_child` - nút con cấu thành nút cha).
* `is_active` (Boolean): Trạng thái của liên kết (để vô hiệu hóa khi minh chứng bị xóa/rút mà không làm mất lịch sử).

#### Nhóm 2.2: Quản lý Hàng đợi & Tính toán lặp (Recalculation Engine)

Thay vì dùng JSON để lưu danh sách các nút bị ảnh hưởng trong bộ nhớ tạm, ta dùng Database để đảm bảo nếu server bị crash, quá trình tính toán lại vẫn có thể tiếp tục (Resilience).

**Bảng 2: `recalculation_batches` (Lô xử lý tính toán lại)**
Mỗi khi một sự kiện thay đổi (ở bảng `twin_update_events`) xảy ra, thuật toán duyệt đồ thị sẽ gom tất cả các nút tìm được vào một lô (batch).

* `id` (UUID, Primary)
* `trigger_event_id` (UUID, Foreign Key $\rightarrow$ `twin_update_events.id`): Sự kiện gốc kích hoạt lần duyệt đồ thị này.
* `status` (Enum/String): `pending`, `processing`, `completed`, `failed`.
* `started_at` (Datetime, Nullable)
* `completed_at` (Datetime, Nullable)

**Bảng 3: `recalculation_tasks` (Nhiệm vụ tính toán từng nút logic)**
Bảng này giải quyết yêu cầu quan trọng nhất của Sáng chế: Tính toán cục bộ và Kiểm tra hội tụ đối với các chu trình lặp.

* `id` (UUID, Primary)
* `batch_id` (UUID, Foreign Key $\rightarrow$ `recalculation_batches.id`)
* `target_state_node_id` (UUID, Foreign Key $\rightarrow$ `twin_state_nodes.id`): Nút cần được tính toán lại.


* `status` (Enum/String): `pending`, `calculating`, `converged` (đã hội tụ), `non_converged` (không hội tụ), `skipped_no_change` (bỏ qua vì không đổi).


* `iteration_count` (Integer): Số lần đã lặp. Sáng chế yêu cầu nếu có vòng lặp, hệ thống sẽ tính lại cho đến khi dấu vân tay kết quả không đổi hoặc "đạt giới hạn lặp xác định trước". Cột này dùng để đếm số vòng lặp.


* `last_snapshot_hash` (String, Nullable): Mã băm của trạng thái ứng viên ở vòng lặp liền trước để so sánh xem đã "hội tụ" chưa.


* `error_message` (Text, Nullable): Ghi nhận lỗi nếu không đạt điều kiện hội tụ.



---

### 3. Đánh giá luồng dữ liệu (Data Flow) và Hiện thực hóa Sáng chế

Thiết kế trên khớp hoàn hảo với các yêu cầu kỹ thuật (Claims) trong Bản mô tả sáng chế:

1. **Tự động dệt đồ thị (Graph Weaving):**
Khi một Bản ghi ánh xạ (Evidence Mapping) được chuyên gia duyệt ở phân hệ trước, Laravel Observer sẽ tự động `INSERT` các dòng vào bảng `dependency_links` (Bảng 1). Nó sẽ tạo 1 dòng trỏ từ `evidence_id` đến `target_state_node_id`, và 1 dòng trỏ từ `scoring_rule_family_id` đến `target_state_node_id`.


2. **Truy vấn duyệt đồ thị (Graph Traversal):**
* Giả sử THUCHOCVN cập nhật phiên bản quy tắc xử lý (Rule Version mới) cho một họ quy tắc cụ thể. Sự kiện này được tiếp nhận.


* Hệ thống dùng Eloquent Query: `SELECT target_state_node_id FROM dependency_links WHERE source_object_type = 'scoring_rule_family' AND source_object_id = ?`.
* Hệ thống ngay lập tức lấy được chính xác danh sách các Nút Logic đang dùng họ quy tắc này (Tập nút bị ảnh hưởng) mà không cần quét toàn bộ CSDL.




3. **Xử lý An toàn Chu trình lặp (Cycle Handling):**
* Các Nút Logic tìm được sẽ được `INSERT` vào bảng `recalculation_tasks` (Bảng 3).
* Job chạy nền (Queue) của Laravel sẽ bốc từng task ra tính toán. Nếu Nút A phụ thuộc Nút B, và Nút B phụ thuộc Nút A (tạo thành chu trình), Job sẽ lặp lại việc tính điểm. Mỗi lần tính xong, nó ghi đè tạm vào `last_snapshot_hash` và tăng `iteration_count` += 1.
* Nếu `last_snapshot_hash` của vòng n bằng vòng n-1, task được đánh dấu `converged` (Hội tụ). Nếu `iteration_count` vượt quá 10 (ngưỡng an toàn cấu hình trước), task bị đánh dấu `non_converged`, hệ thống ghi nhận lỗi và KHÔNG công bố kết quả chưa ổn định làm trạng thái hiện hành.


Thiết kế CSDL dạng này không chỉ bảo đảm **nguyên tắc không JSON** mà còn chuyển đổi một bài toán cấu trúc dữ liệu đồ thị (Graph Data Structure) phức tạp thành các bảng quan hệ (Relational DB) cực kỳ dễ quản trị, index và tối ưu tốc độ trên MySQL/PostgreSQL của Laravel.

---

### 4. Hiệu chỉnh hiệu năng cho khóa chính: ULID/UUID v7 thay cho UUID v4

**Vấn đề:** Toàn bộ thiết kế (mục 2 ở trên và các phân hệ khác trong tài liệu này) đang mặc định dùng `UUID` (ngầm định là UUID v4 - sinh ngẫu nhiên hoàn toàn) làm khóa chính cho mọi bảng. UUID v4 bảo mật tốt (không đoán được ID kế tiếp) nhưng có nhược điểm chí mạng về hiệu năng ghi/đọc:

* **Phân mảnh chỉ mục (Index Fragmentation):** Vì giá trị sinh ra ngẫu nhiên, mỗi lần `INSERT` một dòng mới, engine CSDL (InnoDB) phải chèn vào một vị trí ngẫu nhiên trong B-Tree index thay vì nối vào cuối. Điều này gây phân mảnh trang (page split) liên tục, làm chậm ghi và giảm hiệu quả cache.
* **JOIN trên chuỗi 36 ký tự:** Đồ thị phụ thuộc là nơi chịu ảnh hưởng nặng nhất, vì đây chính là bài toán duyệt đồ thị (graph traversal) tần suất cao: truy vấn `dependency_links` để tìm `target_state_node_id`, rồi JOIN ngược lại `twin_state_nodes`, `twin_snapshots`, `recalculation_tasks`... Khi các bảng này đạt hàng triệu dòng, so khớp (so sánh, sắp xếp) trên khóa dạng chuỗi 36 ký tự tốn CPU/IO hơn nhiều so với so khớp trên kiểu số nguyên có thể sắp xếp.
* **Không có tính cục bộ theo thời gian (No temporal locality):** Các bản ghi được tạo gần nhau về mặt thời gian (VD: các `dependency_links` được dệt ra trong cùng một lần duyệt đồ thị) lại nằm rải rác khắp index, trong khi phần lớn truy vấn nghiệp vụ (lấy các sự kiện/snapshot gần nhất, phân trang theo thời gian) lẽ ra được hưởng lợi nếu dữ liệu mới nằm liền kề nhau.

**Khuyến nghị hiệu chỉnh:** Đội dev Laravel thay `UUID` v4 truyền thống bằng **ULID** (Universally Unique Lexicographically Sortable Identifier) hoặc **UUID v7** cho khóa chính của mọi bảng trong hệ thống, đặc biệt là các bảng lõi của Đồ thị phụ thuộc (`twin_state_nodes`, `dependency_links`, `recalculation_batches`, `recalculation_tasks`, `twin_snapshots`, `twin_update_events`).

* **Cơ chế:** Cả ULID và UUID v7 đều ghép một tiền tố timestamp (thời điểm tạo, chính xác tới mili-giây) ở đầu giá trị, phần còn lại mới là thành phần ngẫu nhiên. Nhờ vậy, ID sinh ra sau luôn lớn hơn (về mặt sắp xếp từ điển) ID sinh ra trước — tức là **tự sắp xếp theo thời gian (monotonic)** — trong khi vẫn giữ được tính duy nhất toàn cục và không đoán được phần ngẫu nhiên.
* **Lợi ích trực tiếp cho Đồ thị phụ thuộc:** Khi `INSERT` các dòng mới vào `dependency_links` (lúc Observer "dệt đồ thị") hoặc `recalculation_tasks` (lúc gom batch), các bản ghi luôn được ghi nối vào cuối B-Tree index thay vì chèn ngẫu nhiên → giảm page split, tăng tốc ghi hàng loạt (batch insert) đáng kể — đúng vào thời điểm hệ thống chịu tải cao nhất (một sự kiện kích hoạt lan truyền tới hàng trăm/hàng nghìn nút).
* **Lợi ích cho truy vấn duyệt đồ thị:** Việc JOIN/lọc theo `target_state_node_id`, `batch_id`, `state_node_id`... vẫn dùng index B-Tree bình thường, nhưng vì index "gọn" hơn (ít phân mảnh) nên tốc độ tra cứu và duyệt nhanh hơn đáng kể so với UUID v4 ngẫu nhiên, đặc biệt khi bảng đạt quy mô hàng triệu dòng.
* **Triển khai trong Laravel:** Dùng trait `Illuminate\Database\Eloquent\Concerns\HasUlids` (Laravel hỗ trợ sẵn từ bản 9+) thay cho `HasUuids` trên các model; hoặc dùng UUID v7 qua thư viện `symfony/uid` (`Symfony\Component\Uid\UuidV7`) nếu muốn giữ đúng chuẩn UUID (tương thích RFC 9562) thay vì định dạng Base32 riêng của ULID. Cột migration vẫn khai báo kiểu `uuid()`/`ulid()` (26 ký tự Base32 với ULID, hoặc 36 ký tự chuẩn UUID với UUID v7) — không đổi kiểu dữ liệu cột, chỉ đổi cách sinh giá trị.
* **Lưu ý bảo mật:** Vì ULID/UUID v7 lộ ra thời điểm tạo bản ghi (timestamp ở tiền tố), với các bảng nhạy cảm cần "không đoán được thứ tự phát sinh" ra bên ngoài (VD: `consents`, `share_grants` nếu ID bị lộ qua URL công khai) thì cân nhắc giữ UUID v4 hoặc bọc thêm lớp mã hoá/obfuscation khi trả ID ra API công khai; còn lại toàn bộ các bảng nội bộ, đặc biệt là các bảng phục vụ Đồ thị phụ thuộc, nên chuyển sang ULID/UUID v7 làm tiêu chuẩn mặc định.

**Áp dụng toàn hệ thống:** Khuyến nghị này không chỉ giới hạn ở Đồ thị phụ thuộc. Toàn bộ các ghi chú "khóa chính" ở đầu mỗi phân hệ trong tài liệu này đã được đồng bộ chỉ về ULID/UUID v7 làm tiêu chuẩn mặc định (thay vì UUID v4), ưu tiên hiệu chỉnh sớm nhất ở các bảng có tốc độ ghi cao và bị JOIN nhiều: `twin_state_nodes`, `dependency_links`, `twin_snapshots`, `evidence_criterion_mappings`, `assessment_criterion_results`.

-------------------------------------------------------------------------------
Dựa trên Đặc tả kỹ thuật MVP v0.1 (Yêu cầu GAP-01) và Bản thuyết minh chi tiết (Mục V.6: Đối chiếu và phân tích khoảng cách năng lực), **Phân hệ Phân tích khoảng cách (Gap Analysis)** là cầu nối chiến lược chuyển hóa dữ liệu đánh giá thành các quyết định đào tạo và phát triển.

Bản thuyết minh nhấn mạnh một nguyên tắc rất quan trọng: *"Khoảng cách không chỉ là phép trừ giữa hai điểm số. Kết quả phải chỉ ra tiêu chí chưa đáp ứng, dữ liệu và minh chứng còn thiếu, độ tin cậy, mức ưu tiên..."*.

Để tuân thủ yêu cầu **KHÔNG sử dụng JSON** (giúp hệ thống dễ dàng truy vấn như: "Đếm số nhân viên đang thiếu kỹ năng AIW-02 ở mức M3"), dữ liệu của phân hệ này phải được chuẩn hóa thành các bảng chi tiết.

Dưới đây là phân tích ngữ cảnh và thiết kế CSDL chi tiết cho Phân hệ Gap Analysis:

### 1. Phân tích ngữ cảnh chi tiết và Luồng nghiệp vụ

* **Đầu vào (Inputs):** Hệ thống nạp 2 nguồn dữ liệu. Một là **Trạng thái hiện tại (T0)** lấy từ bảng `twin_snapshots` (Phân hệ Động cơ Bản sao số). Hai là **Mức yêu cầu mục tiêu** lấy từ bảng `role_profile_competencies` (Phân hệ Hồ sơ vị trí).


* **Phân loại Khoảng cách (Gap Categories):** Kết quả so sánh không trả về một con số vô tri, mà phải được phân vào 6 nhóm trạng thái: (1) Đã đáp ứng, (2) Cần củng cố, (3) Chưa đáp ứng, (4) Chưa đủ dữ liệu, (5) Cần xác minh lại/Hết hiệu lực, (6) Không thuộc phạm vi ưu tiên.


* **Chỉ rõ nguyên nhân (Missing Evidences/Criteria):** Yêu cầu GAP-01 chỉ rõ phải hiển thị được minh chứng nào còn thiếu. Do đó, ta cần một bảng con để liệt kê chính xác các "lỗ hổng" (ví dụ: thiếu chứng chỉ ISO, hoặc điểm tự đánh giá thấp) thay vì lưu vào một mảng JSON.


* **Kích hoạt Kế hoạch phát triển (Triggering DEV):** Kết quả từ phân hệ này là cơ sở trực tiếp để tạo ra Kế hoạch phát triển (Development Plan) ở bước tiếp theo.



---

### 2. Thiết kế Cơ sở dữ liệu (Database Schema)

Sử dụng khóa chính dạng ULID/UUID v7 (thay UUID v4 truyền thống — xem khuyến nghị hiệu chỉnh hiệu năng tại phân hệ Đồ thị phụ thuộc, Mục 4), tích hợp `timestamps()` và `softDeletes()`.

#### Nhóm 2.1: Báo cáo Phân tích tổng thể (The Header)

**Bảng 1: `gap_analyses` (Báo cáo Phân tích Khoảng cách)**
Lưu trữ thông tin tổng quan của một lần chạy phân tích cho một cá nhân đối chiếu với một vị trí.

* `id` (UUID, Primary)
* `person_id` (UUID, Foreign Key $\rightarrow$ `persons.id`): Chủ thể được phân tích.


* `role_profile_id` (UUID, Foreign Key $\rightarrow$ `role_profiles.id`): Hồ sơ vị trí mục tiêu được dùng làm hệ quy chiếu.


* `campaign_id` (UUID, Nullable, Foreign Key $\rightarrow$ `pilot_campaigns.id`): Nếu việc phân tích này nằm trong một chiến dịch Pilot.


* `analyzed_at` (Datetime): Thời điểm chốt báo cáo phân tích.
* `status` (Enum/String): `draft` (bản nháp hệ thống tự tính), `finalized` (đã chốt để lên kế hoạch), `superseded` (bị thay thế khi có T1 mới).



#### Nhóm 2.2: Chi tiết Khoảng cách theo Năng lực (The Line Items)

**Bảng 2: `gap_analysis_items` (Chi tiết Khoảng cách theo từng Năng lực)**
Bảng này đối chiếu 1-1 giữa Mức hiện tại và Mức mục tiêu. Việc loại bỏ JSON giúp ta có thể SUM, AVG các khoảng cách này để lên Dashboard (DB-02).

* `id` (UUID, Primary)
* `gap_analysis_id` (UUID, Foreign Key $\rightarrow$ `gap_analyses.id`)
* `role_profile_competency_id` (UUID, Foreign Key $\rightarrow$ `role_profile_competencies.id`): Năng lực mục tiêu (có chứa Mức yêu cầu `target_level` và tính bắt buộc `is_mandatory`).


* `current_snapshot_id` (UUID, Nullable, Foreign Key $\rightarrow$ `twin_snapshots.id`): Trạng thái Bản sao số hiện hành (T0) được dùng để đem ra so sánh. Nếu bằng Null nghĩa là cá nhân chưa từng được chấm năng lực này.


* `gap_category` (Enum/String): Phân loại kết quả nghiệp vụ theo đúng Thuyết minh: `met` (đã đáp ứng), `needs_reinforcement` (cần củng cố), `unmet` (chưa đáp ứng), `insufficient_data` (chưa đủ dữ liệu), `expired` (minh chứng hết hạn).


* `numeric_gap` (Decimal, 5, 2): Chênh lệch số học (Ví dụ: Mục tiêu M3, Hiện tại M1 $\rightarrow$ Gap = -2.0). Cột này dùng để sắp xếp (ORDER BY) ưu tiên đào tạo.


* `confidence_status` (Enum/String): So sánh độ tin cậy. (VD: Đạt M3 nhưng độ tin cậy C1 thì vẫn báo động đỏ `low_confidence`).



#### Nhóm 2.3: Bóc tách Nguyên nhân Khoảng cách (The Missing Pieces)

Để không lưu mảng JSON các lý do thiếu sót, ta thiết kế một bảng con chi tiết. Bảng này cực kỳ hữu ích cho AI Orchestrator khi đọc dữ liệu để sinh ra lời gợi ý Kế hoạch phát triển (Use case AI-05).

**Bảng 3: `gap_missing_requirements` (Chi tiết các yêu cầu còn thiếu)**

* `id` (UUID, Primary)
* `gap_analysis_item_id` (UUID, Foreign Key $\rightarrow$ `gap_analysis_items.id`)
* `missing_type` (Enum/String): `missing_evidence` (thiếu file minh chứng), `failed_criterion` (chưa đạt tiêu chí con), `expired_evidence` (minh chứng có nhưng đã hết hạn).


* `role_profile_evidence_id` (UUID, Nullable, Foreign Key $\rightarrow$ `role_profile_evidences.id`): Trỏ thẳng về quy định minh chứng bị thiếu (VD: ID của quy định "Phải có chứng chỉ ISO").


* `criterion_id` (UUID, Nullable, Foreign Key $\rightarrow$ `criteria.id`): Trỏ về tiêu chí chưa đạt.


* `description` (String): Diễn giải dễ hiểu cho người dùng (VD: "Chứng chỉ ISO 22000 đã hết hạn vào tháng trước").



---

### 3. Đánh giá luồng dữ liệu (Data Flow) và Giá trị của Thiết kế

1. **Hỗ trợ Ra quyết định Đào tạo (Training Needs Analysis):** Nhờ thiết kế chuẩn hóa Relational DB, ở Cổng Doanh nghiệp (Dashboard DB-02), Quản lý có thể chạy câu SQL đơn giản: *Tập hợp tất cả `gap_analysis_items` có `gap_category = unmet` thuộc nhóm nhân viên Kho*. Hệ thống ngay lập tức vẽ ra biểu đồ thiếu hụt kỹ năng của cả phòng ban mà không tốn tài nguyên parse JSON.


2. **Xử lý bài toán "Chưa đủ dữ liệu":** Bảng 2 giải quyết triệt để yêu cầu nghiệp vụ: Phân biệt rõ "Thiếu năng lực" và "Chưa đủ dữ liệu". Nếu `current_snapshot_id` trỏ về một Snapshot có mức `M0` (Insufficient Data), cột `gap_category` sẽ được gán là `insufficient_data`. Hệ thống sẽ không trừ điểm, mà ở Bảng 3 sẽ tự động generate ra các dòng `missing_evidence` yêu cầu nhân viên bổ sung hồ sơ thay vì ép đi học.


3. **Kích hoạt Module Liền kề (Kế hoạch phát triển):** Dữ liệu từ bảng `gap_missing_requirements` là đầu vào hoàn hảo cho module Lập Kế hoạch Phát triển (DEV-01, DEV-02). Nếu Bảng 3 báo `missing_evidence` (Thiếu sản phẩm thực tế), hệ thống/Kế hoạch sẽ tự động gợi ý "Giao nhiệm vụ thực hành". Nếu Bảng 3 báo `failed_criterion` (Thiếu kiến thức), hệ thống sẽ gợi ý "Khóa học ngắn hạn". Mọi thứ được liên kết logic bằng ID mà không cần AI phải nội suy lại từ đầu.

-------------------------------------------------------------------------------
Dựa trên Đặc tả kỹ thuật MVP v0.1 (Yêu cầu DEV-01 đến DEV-04) và Bản thuyết minh chi tiết (Mục VII.4: Thực hiện hoạt động phát triển), **Phân hệ Kế hoạch phát triển (Development Plan)** là bước chuyển hóa mang tính hành động (Actionable) của toàn bộ hệ thống.

Nếu Phân hệ *Gap Analysis* chỉ ra "bạn đang thiếu gì", thì Phân hệ này trả lời câu hỏi "bạn cần làm gì, trong bao lâu, ai hỗ trợ và kết quả tạo ra là gì để bù đắp khoảng trống đó".

Đặc biệt, hệ thống quy định nguyên tắc cốt lõi: *"Không mặc nhiên coi việc hoàn thành khóa học hoặc hoạt động là đã nâng mức năng lực; trạng thái chỉ được cập nhật khi có minh chứng phù hợp và đủ điều kiện đánh giá"* (Quy tắc sinh ra trạng thái T1).

Để tuân thủ yêu cầu **KHÔNG sử dụng JSON**, dưới đây là phân tích ngữ cảnh và thiết kế CSDL chuẩn hóa chi tiết:

### 1. Phân tích ngữ cảnh chi tiết và Luồng nghiệp vụ

* **Tính kế thừa (Inheritance):** Kế hoạch phát triển kế thừa trực tiếp từ Báo cáo Khoảng cách (Gap Analysis). Mỗi mục tiêu trong kế hoạch phải neo vào một năng lực cần cải thiện đã được phát hiện trước đó.


* **Đa dạng loại hình hoạt động (DEV-02):** Hoạt động không chỉ là "đi học". Nó có thể là khóa học, bài thực hành, nhiệm vụ thực tế tại nơi làm việc, dự án cải tiến, hoặc quá trình được kèm cặp/cố vấn (mentoring). Mỗi hoạt động phải có KPI và thời hạn rõ ràng.


* **Người hỗ trợ (Mentorship):** Cần lưu rõ ai là người hướng dẫn, cố vấn hoặc xác nhận cho hoạt động đó.


* **Human-in-the-loop (DEV-04):** AI có thể đọc kết quả Gap Analysis và gợi ý một lộ trình học tập, nhưng Kế hoạch này ban đầu chỉ ở trạng thái "nháp" (draft). Người dùng hoặc Quản lý phải trực tiếp chọn, sửa và phê duyệt (approved) thì kế hoạch mới chính thức có hiệu lực.


* **Khép kín vòng lặp (Closing the loop):** Đầu ra của một Hoạt động phát triển bắt buộc phải là một hoặc nhiều **Minh chứng mới** (New Evidences). Các minh chứng này sẽ được đẩy ngược lại Phân hệ Intake $\rightarrow$ Workflow $\rightarrow$ Assessment để chấm điểm lại, từ đó Động cơ Bản sao số sinh ra trạng thái T1.



---

### 2. Thiết kế Cơ sở dữ liệu (Database Schema)

Sử dụng khóa chính dạng ULID/UUID v7 (thay UUID v4 truyền thống — xem khuyến nghị hiệu chỉnh hiệu năng tại phân hệ Đồ thị phụ thuộc, Mục 4), tích hợp `timestamps()` và `softDeletes()`.

#### Nhóm 2.1: Kế hoạch Tổng thể (The Plan Header)

**Bảng 1: `development_plans` (Kế hoạch Phát triển Tổng thể)**
Lưu trữ thông tin bao trùm của một bản kế hoạch, đáp ứng yêu cầu DEV-01.

* `id` (UUID, Primary)
* `person_id` (UUID, Foreign Key $\rightarrow$ `persons.id`): Chủ thể thực hiện kế hoạch.
* `gap_analysis_id` (UUID, Nullable, Foreign Key $\rightarrow$ `gap_analyses.id`): Liên kết trực tiếp về bản báo cáo khoảng cách đã kích hoạt kế hoạch này.
* `name` (String): Tên kế hoạch (VD: "Lộ trình hoàn thiện năng lực QC Quý 4/2026").
* `status` (Enum/String): `draft` (bản nháp do AI hoặc hệ thống tạo), `approved` (đã được duyệt), `in_progress` (đang thực hiện), `completed` (đã hoàn thành), `cancelled` (đã hủy).


* `approved_by_id` (UUID, Nullable, Foreign Key $\rightarrow$ `persons.id`): Người quản lý phê duyệt kế hoạch này.


* `start_date` (Date): Ngày bắt đầu.
* `target_date` (Date): Ngày mục tiêu hoàn thành toàn bộ.

#### Nhóm 2.2: Mục tiêu Kế hoạch (The Goals)

**Bảng 2: `development_plan_goals` (Các mục tiêu năng lực cần cải thiện)**
*Không dùng JSON mảng mục tiêu. Bảng này bóc tách từng năng lực cần học.*

* `id` (UUID, Primary)
* `plan_id` (UUID, Foreign Key $\rightarrow$ `development_plans.id`)
* `role_profile_competency_id` (UUID, Foreign Key $\rightarrow$ `role_profile_competencies.id`): Trỏ về yêu cầu năng lực cụ thể của vị trí.


* `baseline_snapshot_id` (UUID, Nullable, Foreign Key $\rightarrow$ `twin_snapshots.id`): Lưu lại trạng thái T0 (Đường cơ sở) tại thời điểm lập kế hoạch để sau này lấy ra so sánh trước-sau.


* `target_proficiency_level_id` (UUID, Foreign Key $\rightarrow$ `proficiency_levels.id`): Mức thành thạo muốn đạt tới (VD: M3).

#### Nhóm 2.3: Hoạt động Hành động (The Actionable Activities)

**Bảng 3: `development_activities` (Chi tiết các hoạt động)**
Bảng này giải quyết yêu cầu DEV-02. Một mục tiêu (Goal) có thể cần nhiều Hoạt động (Activities) để hoàn thành.

* `id` (UUID, Primary)
* `plan_goal_id` (UUID, Foreign Key $\rightarrow$ `development_plan_goals.id`)
* `activity_type` (Enum/String): `course` (khóa học), `practical_task` (nhiệm vụ thực tế), `mentoring` (kèm cặp), `project` (dự án), `process_improvement` (cải tiến quy trình).


* `name` (String): Tên hoạt động (VD: "Khóa học Ứng dụng AI cho công việc").
* `provider_org_id` (UUID, Nullable, Foreign Key $\rightarrow$ `organizations.id`): Đơn vị tổ chức (Cơ sở đào tạo hoặc Doanh nghiệp nội bộ).


* `supporter_person_id` (UUID, Nullable, Foreign Key $\rightarrow$ `persons.id`): Người hướng dẫn, mentor hoặc quản lý giám sát.


* `kpi_description` (Text): Mô tả kết quả cần đạt/KPI (VD: "Phải hoàn thành 3 kịch bản video bằng AI").


* `status` (Enum/String): `planned`, `in_progress`, `completed`, `cancelled`.


* `start_date` (Date)
* `due_date` (Date)

#### Nhóm 2.4: Vòng lặp Minh chứng (Closing the Loop to EVM)

Đây là bảng quan trọng nhất để nối Phân hệ Phát triển trở lại Phân hệ Thu thập (Intake), hiện thực hóa quy tắc "Hoàn thành khóa học chưa chắc đã tăng điểm, phải có minh chứng".

**Bảng 4: `development_activity_outcomes` (Minh chứng Đầu ra của Hoạt động)**

* `id` (UUID, Primary)
* `activity_id` (UUID, Foreign Key $\rightarrow$ `development_activities.id`)
* `expected_evidence_type` (String): Loại minh chứng kỳ vọng hệ thống đòi hỏi (VD: `certificate`, `work_product`).


* `actual_evidence_id` (UUID, Nullable, Foreign Key $\rightarrow$ `evidences.id`): Khi cá nhân upload tài liệu lên hệ thống (ở Phân hệ Intake), ID của minh chứng đó được update ngược vào đây để đánh dấu là đã nộp bài.



---

### 3. Đánh giá luồng dữ liệu (Data Flow) và Giá trị của Thiết kế

1. **AI Orchestrator Tích hợp (DEV-04):** Khi chạy tác vụ AI (AI-05: Gợi ý kế hoạch phát triển), AI sẽ truy vấn bảng `gap_missing_requirements` (Phân hệ Gap) và sinh ra các bản ghi INSERT trực tiếp vào bảng `development_activities` với trạng thái `status = planned` và thuộc một Kế hoạch có trạng thái `draft`. Quản lý vào xem, có thể sửa `supporter_person_id` (phân công mentor) hoặc xóa bớt hoạt động, sau đó nhấn "Approve". Điều này loại bỏ hoàn toàn việc phải lưu raw JSON của AI, dữ liệu lập tức trở thành dữ liệu có cấu trúc.


2. **So sánh Trước - Sau (Pre/Post Intervention - DEV-03):** Nhờ việc lưu `baseline_snapshot_id` (T0) ngay tại Bảng `development_plan_goals`, khi toàn bộ minh chứng mới được duyệt và Động cơ Bản sao số sinh ra trạng thái T1, hệ thống có thể dễ dàng query: *"Lấy điểm số của T1 trừ đi điểm số của T0 (baseline) để ra mức độ tăng trưởng năng lực của khóa học này"*. Từ đó đo lường được ROI (Return on Investment) của hoạt động đào tạo cho cơ sở giáo dục và doanh nghiệp.


3. **Hệ thống thông báo và Tracking (NT-01):** Cấu trúc bảng `development_activities` có chứa `due_date` và `status`. Việc này cho phép cấu hình các Laravel Console Commands (Cronjobs) chạy hằng ngày. Nếu một hoạt động sắp đến `due_date` mà Bảng 4 (`development_activity_outcomes`) vẫn có `actual_evidence_id` là NULL, hệ thống sẽ tự động trigger Email/Zalo nhắc nhở nhân viên nộp minh chứng.