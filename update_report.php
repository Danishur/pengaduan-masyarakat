<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Report</title>
    <link rel="stylesheet" href="update.css">
</head>
<body>
    <div class="container">
        <header>
            <h2>Update Report</h2>
            <a href="dashboard.php" class="back-button">Back to Dashboard</a>
        </header>
        <form action="update_report_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="report_id" value="<?php echo $_GET['id']; ?>">
            
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" placeholder="Enter report title" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" rows="5" placeholder="Enter report description" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="image">Upload Image (optional):</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>
            
            <button type="submit">Update Report</button>
        </form>
    </div>
</body>
</html>
