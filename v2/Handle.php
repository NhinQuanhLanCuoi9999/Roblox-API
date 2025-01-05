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
      

        // Kiểm tra nếu có dữ liệu bạn bè
        if (!empty($friendsData['data'])) {
            foreach ($friendsData['data'] as $friend) {
                $friendName = strtolower($friend['name']);
                $friendDisplayName = strtolower($friend['displayName']);

                // Kiểm tra trạng thái bạn bè
               {
        {
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