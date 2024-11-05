<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Roblox User Info</title>
 <style>
    body {
     font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 50px;
        background-color: Azure;
        color: #555;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    h1 {
        color: #4CAF50;
        margin-bottom: 20px;
        text-align: center;
        font-size: 2.5rem; /* Cỡ chữ lớn hơn */
        font-weight: bold;
        letter-spacing: 1px; /* Khoảng cách giữa các chữ cái */
    }

    form {
        background: #ffffff;
        padding: 40px;
        border-radius: 12px; /* Bo góc lớn hơn */
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15); /* Đổ bóng rõ hơn */
        width: 98%;
        max-width: 600px;
        text-align: center;
        margin-bottom: 20px;
        transition: transform 0.3s; /* Hiệu ứng khi hover */
    }

    form:hover {
        transform: translateY(-5px); /* Nâng nhẹ khi hover */
    }

    input[type="number"], select, input[type="date"] {
        max-width: 400px;
        width: 100%;
        padding: 14px; /* Tăng khoảng cách bên trong */
        margin: 0 auto 16px auto;
        border: 1px solid #ccc;
        border-radius: 6px; /* Bo góc nhẹ nhàng */
        font-size: 16px;
        transition: border-color 0.3s, box-shadow 0.3s; /* Hiệu ứng cho input */
    }

    button {
        width: 100%;
        padding: 14px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 18px; /* Cỡ chữ lớn hơn */
        font-weight: bold; /* Chữ đậm */
        transition: background-color 0.3s, transform 0.2s;
    }

    h2 {
        text-align: center;
        font-size: 32px; /* Giảm cỡ chữ một chút */
        margin: 20px 0;
        font-weight: bold;
    }

    button:hover {
        background-color: #45a049;
        transform: scale(1.05); /* Tăng kích thước khi hover */
    }

    .user-info, #friendsList {
        max-width: 98%;
        margin: 40px auto;
        padding: 130px; /* Giảm padding để nội dung không bị quá rộng */
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        width: 100%;
        font-family: 'Roboto Mono', monospace;
        border-left: 5px solid #4CAF50; /* Đường viền bên trái để nhấn mạnh */
       transform: translate(-130px, 0px); 
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        margin-bottom: 15px;
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        background-color: #fafafa;
        transition: background-color 0.3s, transform 0.2s; /* Hiệu ứng cho các mục trong danh sách */
    }

    li:hover {
        background-color: #f0f0f0; /* Màu nền sáng hơn khi hover */
        transform: scale(1.02); /* Tăng kích thước một chút khi hover */
    }

    select:focus, input[type="number"]:focus, input[type="date"]:focus {
        border-color: #4CAF50;
        outline: none;
        box-shadow: 0 0 8px rgba(76, 175, 80, 0.5); /* Đổ bóng khi focus */
    }

    option {
        padding: 10px;
    }
    .advanced-options {
        overflow: hidden;
        max-height: 0;
        opacity: 0;
        transition: max-height 0.3s ease, opacity 0.3s ease;
    }
</style>
</head>
<body>
<h1>ROBLOX API DOCUMENTATION </h1>
<form method="POST" id="userForm">
    <select id="functionSelect" name="functionType" onchange="toggleInput()">
        <option value="">Chọn chức năng</option>
        <option value="userInfo" <?= isset($_POST['functionType']) && $_POST['functionType'] === 'userInfo' ? 'selected' : '' ?>>Lấy thông tin người dùng</option>
        <option value="avatar" <?= isset($_POST['functionType']) && $_POST['functionType'] === 'avatar' ? 'selected' : '' ?>>Lấy avatar</option>
        <option value="friends" <?= isset($_POST['functionType']) && $_POST['functionType'] === 'friends' ? 'selected' : '' ?>>Lấy danh sách bạn bè</option>
                <option value="groupInfo" <?= isset($_POST['functionType']) && $_POST['functionType'] === 'groupInfo' ? 'selected' : '' ?>>Tìm nhóm</option>
    </select>

    <input type="number" id="userId" name="userId" placeholder="Nhập ID User / Nhóm Roblox" required value="<?= isset($_POST['userId']) ? htmlspecialchars($_POST['userId']) : '' ?>" style="display: <?= isset($_POST['functionType']) && $_POST['functionType'] ? 'block' : 'none' ?>;">
    
    <button type="button" id="toggleAdvancedBtn" onclick="toggleAdvancedOptions()" style="display: none; padding: 14px 3px; font-size: 12px; margin-top: 5px; background-color: blue; color: white; border: none; border-radius: 5px; margin-bottom: 15px;">Tùy chọn nâng cao</button>
    
    <div class="advanced-options" id="advancedOptions" style="display: none; align-items: center; gap: 10px; transition: all 0.3s ease;">
     <div style="display: flex; align-items: center; margin-bottom: 10px;">
    <label for="friendStatus" style="margin-right: 10px;"></label>
    <select name="friendStatus" id="friendStatus" style="margin-right: 10px;">
        <option value="">Chọn trạng thái</option>
        <option value="online" <?= isset($_POST['friendStatus']) && $_POST['friendStatus'] === 'online' ? 'selected' : '' ?>>Online</option>
        <option value="offline" <?= isset($_POST['friendStatus']) && $_POST['friendStatus'] === 'offline' ? 'selected' : '' ?>>Offline</option>
    </select>

    <label for="startDate" style="margin-right: 10px;">Từ ngày:</label>
    <input type="date" name="startDate" id="startDate" value="<?= isset($_POST['startDate']) ? htmlspecialchars($_POST['startDate']) : '' ?>" style="margin-right: 10px;">

    <label for="endDate" style="margin-right: 10px;">Đến ngày:</label>
    <input type="date" name="endDate" id="endDate" value="<?= isset($_POST['endDate']) ? htmlspecialchars($_POST['endDate']) : '' ?>" style="margin-right: 10px;">
</div>

<div style="margin-top: -20px; display: flex; align-items: center;">
    <label for="searchName" style="font-size: 16px; color: #333; margin-right: 10px;"></label>
    <input type="text" name="searchName" id="searchName" placeholder="Nhập tên" value="<?= isset($_POST['searchName']) ? htmlspecialchars($_POST['searchName']) : '' ?>" 
        style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; width: 130px; transition: border-color 0.3s; outline: none;" 
        onfocus="this.style.borderColor='#007BFF';" onblur="this.style.borderColor='#ccc';" />
</div>
</div>
    <button type="submit" style="display: <?= isset($_POST['functionType']) && $_POST['functionType'] ? 'block' : 'none' ?>;">Xác nhận</button>
</form>

<div id="output">
    <?php
    // Kiểm tra xem yêu cầu được gửi từ phương thức POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy ID người dùng và loại chức năng từ biểu mẫu
        $userId = intval($_POST['userId']);
        $functionType = $_POST['functionType'];
        
        // Lấy tên tìm kiếm từ biểu mẫu và chuyển đổi thành chữ thường
        $searchName = isset($_POST['searchName']) ? strtolower(trim($_POST['searchName'])) : '';

        // Kiểm tra loại chức năng được chọn
        if ($functionType === "userInfo") {
    // Lấy thông tin người dùng từ API
    $userUrl = "https://users.roblox.com/v1/users/$userId";
    $userResponse = @file_get_contents($userUrl);
    $userData = json_decode($userResponse, true);
    
    if ($userData) {
        // Hiển thị thông tin người dùng
        echo "<div class='user-info'>";
echo "<h2><strong>Thông tin người dùng:</strong></h2>";
echo "<strong>Username:</strong> {$userData['name']}<br>";
echo "<strong>Tên hiển thị:</strong> {$userData['displayName']}<br>";
echo "<strong>ID: </strong> <a href='https://www.roblox.com/users/{$userData['id']}/profile?friendshipSourceType=PlayerSearch' target='_blank'> {$userData['id']}</a> <br>";
echo "<strong>Mô tả:</strong> " . ($userData['description'] ?: 'Không có mô tả') . "<br>";
echo "<strong>Ngày tạo:</strong> " . date('d-m-Y | H:i:s', strtotime($userData['created'])) . "<br>";
echo "<strong>Bị cấm:</strong> " . ($userData['isBanned'] ? 'Có' : 'Không') . "<br>";
echo "<strong>Tên hiển thị từ ứng dụng bên ngoài:</strong> " . ($userData['externalAppDisplayName'] ?: 'Không có') . "<br>";

$hasVerifiedBadge = $userData['hasVerifiedBadge']; // Lấy thông tin huy hiệu
echo "<strong>Huy hiệu:</strong> " . ($hasVerifiedBadge ? 'Có' : 'Không có') . "<br>";

// Fetch danh sách bạn bè
        $friendsUrl = "https://friends.roblox.com/v1/users/$userId/friends";
        $friendsResponse = @file_get_contents($friendsUrl);
        $friendsData = json_decode($friendsResponse, true);

        if ($friendsData && !empty($friendsData['data'])) {
            // Lấy ID của bạn bè đầu tiên
            $firstFriendId = $friendsData['data'][0]['id'];
            
            // Fetch danh sách bạn bè của bạn bè đầu tiên
            $firstFriendFriendsUrl = "https://friends.roblox.com/v1/users/$firstFriendId/friends";
            $firstFriendFriendsResponse = @file_get_contents($firstFriendFriendsUrl);
            $firstFriendFriendsData = json_decode($firstFriendFriendsResponse, true);

            // Tìm trạng thái của chính người dùng trong danh sách bạn bè của bạn bè đầu tiên
            $foundSelfStatus = false;
            if ($firstFriendFriendsData && !empty($firstFriendFriendsData['data'])) {
                foreach ($firstFriendFriendsData['data'] as $friend) {
                    if ($friend['id'] == $userId) {
                        $foundSelfStatus = true;
                        // Nếu tìm thấy, hiển thị trạng thái của bạn
                        echo "<strong>Trạng thái:</strong> " . ($friend['isOnline'] ? 'Online' : 'Offline') . "<br>";
                        break;
                    }
                }
            }

            if (!$foundSelfStatus) {
                echo "<strong>Không tìm thấy trạng thái của bạn trong danh sách bạn bè của bạn bè đầu tiên.</strong><br>";
            }
        } else {
            echo "<strong>Trạng thái:</strong> Không xác định<br>";
        }
 
        echo "</div>";
        
    } else {
        echo "<p><strong>Không tìm thấy người dùng!</strong></p>";
    }
}
        elseif ($functionType === "avatar") {
    // Lấy avatar người dùng từ API
    $avatarUrl = "https://thumbnails.roblox.com/v1/users/avatar?userIds=$userId&size=420x420&format=Png";
    $avatarResponse = @file_get_contents($avatarUrl);
    $avatarData = json_decode($avatarResponse, true);

    // Kiểm tra nếu dữ liệu trả về là một mảng rỗng
    if (isset($avatarData['data']) && empty($avatarData['data'])) {
        echo "<div class='user-info'>";
        echo "<h2><strong>Avatar người dùng:</strong></h2>";
        echo "<h2>Người dùng không tồn tại</h2>";
        echo "</div>";
    } else {
        $avatarImg = isset($avatarData['data'][0]['imageUrl']) ? $avatarData['data'][0]['imageUrl'] : '';
        $imageUrl = isset($avatarData['data'][0]['imageUrl']) ? $avatarData['data'][0]['imageUrl'] : ''; // Thêm dòng này để lấy imageUrl

        // Hiển thị avatar người dùng
        echo "<div class='user-info'>";
        echo "<h2><strong>Avatar người dùng:</strong></h2>";
        echo "<div style='display: flex; align-items: center; justify-content: center;'>";
        echo "<div style='width: 440px; height: 440px; border-radius: 50%; background-color: #87CEEB; display: flex; align-items: center; justify-content: center;'>";
        echo "<div style='width: 420px; height: 420px; border-radius: 50%; background-color: white; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);'>";
        echo "<img src='$avatarImg' alt='Avatar' style='width: 100%; height: 100%; object-fit: cover;'>";
        echo "</div></div></div>";

        // Hiển thị imageUrl
        if ($imageUrl) {
            echo "<h3><strong>Image URL:</strong> <a href='$imageUrl' target='_blank'>$imageUrl</a></h3>"; // Hiển thị link imageUrl
        }

        echo "</div>";
    }
}
elseif ($functionType === "groupInfo") {
    $groupId = $userId; // Giả sử userId ở đây là groupId
    $groupUrl = "https://groups.roblox.com/v1/groups/$groupId"; // API lấy thông tin nhóm
    $groupResponse = @file_get_contents($groupUrl);

    // Kiểm tra xem phản hồi có lỗi hay không
    if ($groupResponse === FALSE) {
        echo "<div class='error'><strong> ID Nhóm không tồn tại. </strong></div>";
    } else {
        $groupData = json_decode($groupResponse, true);

        // Kiểm tra nếu groupData có lỗi
        if (isset($groupData['errors']) && !empty($groupData['errors'])) {
            // Lấy thông tin lỗi từ phản hồi
            $errorMessage = htmlspecialchars($groupData['errors'][0]['userFacingMessage'] ?? 'Không xác định được lỗi.');
            echo "<div class='error'>Không tìm thấy thông tin cho ID nhóm: $groupId. Lỗi: $errorMessage.</div>";
        } else {
            // Chuyển đổi tên nhóm để sử dụng trong URL
            $groupNameFormatted = str_replace(' ', '-', $groupData['name']); // Thay thế dấu cách bằng dấu gạch ngang
            $groupUrlFormatted = "https://www.roblox.com/groups/{$groupData['id']}/$groupNameFormatted"; // Tạo URL

            echo "<div class='user-info'>";
            echo "<h2><strong>Thông tin nhóm:</strong></h2>";
            echo "<strong>Tên nhóm:</strong> {$groupData['name']}<br>";
            echo "<strong>Mô tả:</strong> " . nl2br(htmlspecialchars($groupData['description'])) . "<br>";
            echo "<strong>ID:</strong> <a href='$groupUrlFormatted'>$groupId</a><br>";
            echo "<strong>Số thành viên:</strong> {$groupData['memberCount']}<br>";
            echo "<strong>Chủ sở hữu:</strong> {$groupData['owner']['displayName']}<br>";
            echo "<strong>Có huy hiệu xác minh:</strong> " . ($groupData['hasVerifiedBadge'] ? 'Có' : 'Không') . "<br>";

            // Thêm đường kẻ ngang
            echo "<hr>";
            echo "<br>";

            // Thêm div cho shout
            if (isset($groupData['shout']) && !empty($groupData['shout'])) {
                echo "<div class='shout-info'>";
                
                // Hiển thị 'username' của người đăng shout với link đến profile
                $userId = $groupData['shout']['poster']['userId']; // Lấy userId của người đăng shout
                $username = htmlspecialchars($groupData['shout']['poster']['username'] ?? 'Không có thông tin');
                echo "<strong>Người đăng: </strong> <a href='https://www.roblox.com/users/$userId/profile' target='_blank'>" . $username . "</a><br>";

                // Hiển thị nội dung shout (shout body)
                $shoutBody = nl2br(htmlspecialchars($groupData['shout']['body'] ?? 'Không có nội dung'));
                echo "<strong>Post:</strong> " . $shoutBody . "<br>";

                // Hiển thị ngày tạo shout
                $createdDate = isset($groupData['shout']['created']) ? date('d-m-Y H:i:s', strtotime($groupData['shout']['created'])) : 'Không có dữ liệu';
                echo "<strong>Ngày tạo:</strong> " . $createdDate . "<br>";

                // Hiển thị ngày cập nhật shout
                $updatedDate = isset($groupData['shout']['updated']) ? date('d-m-Y H:i:s', strtotime($groupData['shout']['updated'])) : 'Không có dữ liệu';
                echo "<strong>Ngày cập nhật:</strong> " . $updatedDate . "<br>";

                echo "</div>";
            } else {
                echo "<p><strong>Không có shout nào!</strong></p>";
            }
            echo "</div>"; // Đóng div.user-info
        }
    }
}
elseif ($functionType === "friends") {
    // Lấy danh sách bạn bè từ API
    $friendsUrl = "https://friends.roblox.com/v1/users/$userId/friends";
    $friendsResponse = @file_get_contents($friendsUrl);
    $friendsData = json_decode($friendsResponse, true);
    $filteredFriends = [];

    // Kiểm tra lỗi từ API
    if (isset($friendsData['errors']) && !empty($friendsData['errors'])) {
        // Nếu có lỗi và thông báo lỗi khớp với mã lỗi 1
        echo "<div id='friendsList'><h1 style='color:red;'><strong>Người dùng không tồn tại.</strong></h1></div>";
    } else {
        // Lấy các bộ lọc trạng thái và ngày
        $statusFilter = $_POST['friendStatus'];
        $startDate = $_POST['startDate'] ? strtotime($_POST['startDate']) : 0;
        $endDate = $_POST['endDate'] ? strtotime($_POST['endDate']) : PHP_INT_MAX;

        // Kiểm tra nếu có dữ liệu bạn bè
        if (!empty($friendsData['data'])) {
            foreach ($friendsData['data'] as $friend) {
                $friendDate = strtotime($friend['created']);
                $friendName = strtolower($friend['name']);
                $friendDisplayName = strtolower($friend['displayName']);

                // Kiểm tra trạng thái bạn bè
                if (
                    ($statusFilter === "online" && $friend['isOnline']) ||
                    ($statusFilter === "offline" && !$friend['isOnline']) ||
                    empty($statusFilter)
                ) {
                    if ($friendDate >= $startDate && $friendDate <= $endDate) {
                        // Kiểm tra tên tìm kiếm
                        if (empty($searchName) || strpos($friendName, $searchName) !== false || strpos($friendDisplayName, $searchName) !== false) {
                            $filteredFriends[] = $friend; // Thêm bạn vào danh sách lọc
                        }
                    }
                }
            }

            // Hiển thị danh sách bạn bè
            if (!empty($filteredFriends)) {
                echo "<div id='friendsList'><h2><strong>Danh sách bạn bè:</strong></h2><ul>";
                foreach ($filteredFriends as $friend) {
                    echo "<li>
                                           <strong>Username: </strong> {$friend['name']} <br>
                        <strong>ID: </strong>      <a href='https://www.roblox.com/users/{$friend['id']}/profile?friendshipSourceType=PlayerSearch' target='_blank'>{$friend['id']} </a><br>
                        <strong>Tên hiển thị:</strong> {$friend['displayName']}<br>
                        <strong>Trạng thái:</strong> " . ($friend['isOnline'] ? 'Online' : 'Offline') . "<br>
                        <strong>Deleted:</strong> " . ($friend['isDeleted'] ? 'Có' : 'Không') . " | 
                        <strong>Banned:</strong> " . ($friend['isBanned'] ? 'Có' : 'Không') . "<br>
                        <strong>Ngày tạo:</strong> " . date('d-m-Y', strtotime($friend['created'])) . "<br>
                    </li>";
                }
                echo "</ul></div>";
            } else {
                echo "<div id='friendsList'><h1 style='color:red;'><strong>Không có thông tin nào để hiện</strong></h1></div>";
            }
        } else {
            // Trường hợp không có dữ liệu bạn bè
            echo "<div id='friendsList'><h1 style='color:red;'><strong>Người dùng này không có bạn bè nào.</strong></h1></div>";
        }
    }
}
}

    ?>
    <?php
// Kiểm tra xem có API fetch khác không và có biến GET hoặc POST nào không
if (!isset($_GET['fetch']) || $_GET['fetch'] !== 'true') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' || !empty($_GET)) {
        // Không hiển thị tiêu đề nếu có POST hoặc GET
        echo "";
    } else {
        // Hiển thị tiêu đề nếu không có GET hoặc POST
        echo '<div class="st"><h1>Một số user hoặc nhóm mà bạn có thể thích</h1></div>';

        // Số lượng mục cần hiển thị (ngẫu nhiên giữa 7 đến 5)
        $limit = rand(12, 15);

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
                echo "<strong>Bị cấm:</strong> " . ($userData['isBanned'] ? 'Có' : 'Không') . "<br>";
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
<script>
    function toggleInput() {
        const select = document.getElementById("functionSelect");
        const input = document.getElementById("userId");
        const button = document.querySelector("button[type='submit']");
        const toggleBtn = document.getElementById("toggleAdvancedBtn");
        const advancedOptions = document.getElementById("advancedOptions");

        // Hiển thị trường ID người dùng và nút xác nhận nếu có chức năng được chọn
        if (select.value) {
            input.style.display = "block";
            button.style.display = "block";
            toggleBtn.style.display = select.value === "friends" ? "block" : "none"; // Hiển thị nút tùy chọn nâng cao nếu chức năng là bạn bè
            advancedOptions.style.display = "none"; // Ẩn tùy chọn nâng cao khi chọn chức năng khác
        } else {
            input.style.display = "none";
            button.style.display = "none";
            toggleBtn.style.display = "none";
            advancedOptions.style.display = "none";
        }
    }

    function toggleAdvancedOptions() {
        const advancedOptions = document.getElementById("advancedOptions");
        // Chuyển đổi hiển thị của tùy chọn nâng cao
        advancedOptions.style.display = advancedOptions.style.display === "none" ? "flex" : "none";

        // Hiệu ứng trượt lên/xuống
        if (advancedOptions.style.display === "flex") {
            advancedOptions.style.maxHeight = "200px"; // Thay đổi giá trị này nếu cần
            advancedOptions.style.opacity = "1";
        } else {
            advancedOptions.style.maxHeight = "0";
            advancedOptions.style.opacity = "0";
        }
    }
</script>
</body>
</html>
