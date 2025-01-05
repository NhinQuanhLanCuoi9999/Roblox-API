<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Roblox User Info</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
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
   include "Handle.php";
    include "Handle2.php";
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