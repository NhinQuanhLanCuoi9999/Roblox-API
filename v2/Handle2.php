<?php
// Kiểm tra xem có API fetch khác không và có biến GET hoặc POST nào không
if (!isset($_GET['fetch']) || $_GET['fetch'] !== 'true') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' || !empty($_GET)) {
        // Không hiển thị tiêu đề nếu có POST hoặc GET
        echo "";
    } else {
        // Hiển thị tiêu đề nếu không có GET hoặc POST
        echo '<div class="st"><h1>Một số user hoặc nhóm mà bạn có thể thích</h1></div>';

        // Số lượng mục cần hiển thị (ngẫu nhiên giữa 4 đến 8)
        $limit = rand(4, 8);

        // Tạo mảng để chứa ID ngẫu nhiên
        $randomIds = [];
        
        // Tạo ID ngẫu nhiên cho user và group với tỷ lệ 50/50
        for ($i = 0; $i < $limit; $i++) {
            $isUser = rand(0, 1) === 0; // 50/50 chọn giữa user và group
            if ($isUser) {
                // ID người dùng ngẫu nhiên từ 1 đến 5537591985
                $randomId = rand(1, 5537591985);
            } else {
                // ID nhóm ngẫu nhiên từ 1 đến 12000000
                $randomId = rand(1, 12000000);
            }
            $randomIds[] = ['id' => $randomId, 'isUser' => $isUser];
        }

        // Thêm thẻ <style> vào đầu trang
        echo "<style>
                .user-box {
                    border: 1px solid #ccc;
                    padding: 15px;
                    margin: 10px 0;
                    width: 720px; /* Đặt độ rộng là 720 pixel */
                    height: 320px; /* Đặt độ cao là 320 pixel */
                    overflow: auto; /* Thêm scroll nếu nội dung vượt quá khung */
                }
                .error {
                    color: red;
                }
              </style>";

        // Hiển thị thông tin cho mỗi ID ngẫu nhiên
        foreach ($randomIds as $item) {
            $id = $item['id'];
            $isUser = $item['isUser'];

            if ($isUser) {
                // Lấy thông tin người dùng từ API
                $userUrl = "https://users.roblox.com/v1/users/$id";
                $userResponse = @file_get_contents($userUrl);
                $userData = json_decode($userResponse, true);
                
                // Tạo khung cho mỗi người dùng
                echo "<div class='user-box'>";
                
                if ($userData) {
                    // Hiển thị thông tin người dùng
                    echo "<strong>Username:</strong> {$userData['name']}<br>";
                echo "<strong>Tên hiển thị:</strong> {$userData['displayName']}<br>";
                echo "<strong>Mô tả:</strong> " . ($userData['description'] ?: 'Không có mô tả') . "<br>";
         echo "<strong>ID:</strong> <a href=\"https://www.roblox.com/users/$id/profile\" target=\"_blank\">
      {$userData['id']}</a> <br>";
             echo "<strong>Ngày tạo:</strong> " . date('d-m-Y | H:i:s', strtotime($userData['created'])) . "<br>";
                echo "<strong>Tên hiển thị từ ứng dụng bên ngoài:</strong> " . ($userData['externalAppDisplayName'] ?: 'Không có') . "<br>";
                echo "<strong>Huy hiệu:</strong> " . ($userData['hasVerifiedBadge'] ? 'Có' : 'Không có') . "<br>";      
                } else {
                    echo "Không thể lấy thông tin cho User ID: $id<br>";
                }
                
                echo "</div>"; // Đóng khung cho mỗi người dùng
            } else {
                // Lấy thông tin nhóm từ API
                $groupUrl = "https://groups.roblox.com/v1/groups/$id"; // API lấy thông tin nhóm
                $groupResponse = @file_get_contents($groupUrl);

                // Kiểm tra xem phản hồi có lỗi hay không
                if ($groupResponse === FALSE) {
                    echo "<div class='error'><strong></strong></div>";
                } else {
                    $groupData = json_decode($groupResponse, true);

                    // Kiểm tra nếu groupData có lỗi
                    if (isset($groupData['errors']) && !empty($groupData['errors'])) {
                        // Lấy thông tin lỗi từ phản hồi
                        $errorMessage = htmlspecialchars($groupData['errors'][0]['userFacingMessage'] ?? 'Không xác định được lỗi.');
                        echo "<div class='error'>Không tìm thấy thông tin cho ID nhóm: $id. Lỗi: $errorMessage.</div>";
                    } else {
                        // Chuyển đổi tên nhóm để sử dụng trong URL
                        $groupNameFormatted = str_replace(' ', '-', $groupData['name']); // Thay thế dấu cách bằng dấu gạch ngang
                        $groupUrlFormatted = "https://www.roblox.com/groups/{$groupData['id']}/$groupNameFormatted"; // Tạo URL

                        echo "<div class='user-box'>";
                   echo "<strong>Tên nhóm:</strong> {$groupData['name']}<br>";
                        echo "<strong>Mô tả:</strong> " . nl2br(htmlspecialchars($groupData['description'])) . "<br>";
              echo "<strong>ID:</strong> <a href=\"$groupUrlFormatted\" target=\"_blank\">$id</a><br>";
                                  echo "<strong>Số thành viên:</strong> {$groupData['memberCount']}<br>";
                        echo "<strong>Chủ sở hữu:</strong> {$groupData['owner']['displayName']}<br>";
                        echo "<strong>Có huy hiệu xác minh:</strong> " . ($groupData['hasVerifiedBadge'] ? 'Có' : 'Không') . "<br>";
                        echo "</div>"; // Đóng khung cho thông tin nhóm
                    }
                }
            }
        }
    }
} else {
    // Nếu có API fetch khác, không thực hiện gì cả
    echo "Không có dữ liệu để hiển thị.";
}
?>