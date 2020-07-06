<?php

// Build a navigation bar using the $classifications array
function buildNavMenu($classifications) {
    $navList = '<ul>';
    $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/vehicles/index.php?action=classification&classificationName=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }
    $navList .= '</ul>';
    return $navList;
}

// ****************************************************
// Functions for validating user data
// ****************************************************

// Function for server side validation of email addresses submitted via forms.
function checkEmail($clientEmail) {
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

// Function for servier side valitation of passwords submitted via forms.
 function checkPassword($clientPassword){
    // Check the password for a minimum of 8 characters,
    // at least one 1 capital letter, at least 1 number and
    // at least 1 special character
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
    return preg_match($pattern, $clientPassword);
}

// ****************************************************
// Functions for validating vehicle/classification data
// ****************************************************

// Function for server side validation of classificationName.
function checkClassificationName($classificationName) {
    $pattern = '/^[a-zA-Z\s]+$/';
    return preg_match($pattern, $classificationName);
}

// Function for server side validation of classificationId.
function validateClassificationId($classificationId) {
    $valClassificationId = filter_var($classificationId, FILTER_VALIDATE_INT);
    return $valClassificationId;
}

// Function for validating strings with the following regex pattern: /^[a-zA-Z\s]*$/
// Returns input string if pattern matches, 0 if not.
function validateStringRegex($stringInput) {
    $pattern = '/^[a-zA-Z\s]+$/';
    $result = preg_match($pattern, $stringInput);
    if($result) {
        return $stringInput;
    } else {
        return null;
    }
}

// Function for validating invModel with the following regex pattern: /^[\w\s]*$/
// Returns input string if pattern matches, 0 if not.
function validateInvModel($invModel) {
    $pattern = '/^[\w\s-]+$/';
    $result = preg_match($pattern, $invModel);
    if($result) {
        return $invModel;
    } else {
        return null;
    }
}

// Function for validating image url path against regex pattern: /^(https:\/\/|http:\/\/|\/){1}.*(\.[A-Za-z]{3,4})$/i
function validateFilePath($pathInput) {
    $pattern = '/^(https:\/\/|http:\/\/|\/){1}.+(\.[A-Za-z]{3,4})$/i';
    $result = preg_match($pattern, $pathInput);
    if($result === 1) {
        return $pathInput;
    } else {
        return null;
    }
}

// Function for validating inventory price against regex pattern: /^([0-9]*)\.?[0-9]{2,2}?$/
    function validateInvPrice($invPrice) {
        $pattern = '/^([0-9]+)\.?[0-9]{2,2}?$/';
        $result = preg_match($pattern, $invPrice);
        if($result) {
            return $invPrice;
        } else {
            return null;
        }
    }

// Function for server side validation of integers.
function validateInt($int) {
    $valInt = filter_var($int, FILTER_VALIDATE_INT);
    return $valInt;
}

// Build the classifications select list 
function buildClassificationList($classifications){ 
    $classificationList = '<select name="classificationId" id="classificationList">'; 
    $classificationList .= "<option>Choose a Classification</option>"; 
    foreach ($classifications as $classification) { 
     $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
    } 
    $classificationList .= '</select>'; 
    return $classificationList; 
}

// Function to build a display of vehicles in a classification within and unordered list
function buildVehiclesDisplay($vehicles){
    $dv = '<ul id="inv-display">';
    foreach ($vehicles as $vehicle) {
     $dv .= '<li class="grow">';
     $dv .= "<a href='/phpmotors/vehicles/?action=vehicle&invId=$vehicle[invId]'>";
     $dv .= "<img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
     $dv .= '<div class="vehicle-details">';
     $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
     $dv .= '<span class="vehicle-price">' . formatCurrencyUSD($vehicle['invPrice']) . '</span>';
     $dv .= '</div>';
     $dv .= '</a>';
     $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}

// Function to build a display for a single vehicle to be displayed on the vehicle-details view.
function buildVehicleDisplay($vehicle){
    $dv = "<h1>$vehicle[invMake] $vehicle[invModel]</h1>";
    $dv .= "<img class='vehicle-full-size' src='$vehicle[invImage]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
    $dv .= '<h2 class="vehicle-price">Price: ' . formatCurrencyUSD($vehicle['invPrice']) . '</h2>';
    $dv .= "<section id='vehicle-details'>";
    $dv .= "<h2>$vehicle[invMake] $vehicle[invModel] Details</h2>";
    $dv .= "<h3>Description</h3><p id='vehicle-description'>$vehicle[invDescription]</p>";
    $dv .= "<h3>Colors Available</h3><p id='vehicle-color'>$vehicle[invColor]</p>";
    $dv .= "<h3>QTY in Stock</h3><p id='vehicle-qty-in-stock'>$vehicle[invStock]</p>";
    $dv .= "</section>";
    return $dv;
}

// Funciton for formatting prices to US currency
function formatCurrencyUSD($price) {
    $formattedCurrency = number_format($price, 0, '.', ',');
    $formattedCurrency = '$' . $formattedCurrency;
    return $formattedCurrency;
}

// Function for generating a users screen name when leaving reviews
function generateScreenName($clientFirstname, $clientLastname) {
    $firstInitial = strtoupper(substr($clientFirstname, 0, 1));
    $lastName = ucfirst($clientLastname);
    return $firstInitial . $lastName;
}

// Function for generating existing reviews on the vehicle-detail view
function buildInventoryReviewsList($invReviews) {
    $reviews = "<div class='all-reviews'>";
    foreach ($invReviews as $singleReview) {
        $reviews .= '<div class="single-review rounded-corners">';
        $screenName = generateScreenName($singleReview['clientFirstname'], $singleReview['clientLastname']);
        $reviewDate = formatReviewDate($singleReview['reviewDate']); 
        $reviews .= "<h3>$screenName <span class='review-meta'>wrote on $reviewDate:</span></h3>";
        $reviews .= "<p>$singleReview[reviewText]</p>";
        if(isset($_SESSION['clientData']) && $_SESSION['clientData']['clientId'] === $singleReview['clientId']) {
            $reviews .= "<span class='review-buttons'>";
            $reviews .= "<a class='grow modify' href='/phpmotors/reviews?action=edit-review&reviewId=$singleReview[reviewId]' title='Click to edit'>Edit</a>";
            $reviews .= "<a class='grow delete' href='/phpmotors/reviews?action=delete-review&reviewId=$singleReview[reviewId]' title='Click to delete'>Delete</a>";
            $reviews .= "</span>";
        }
        $reviews .= '</div>';
       }
    $reviews .= "</div>";
    return $reviews;
}

// Function for generating existing reviews on the user admin view
function buildClientReviewsList($clientReviews) {
    $reviews = "<table>";
    foreach ($clientReviews as $singleReview) {
        $reviews .= '<tr class="single-review">';
        $reviewDate =  formatReviewDate($singleReview['reviewDate']);         
        $reviews .= "<td><a href='/phpmotors/vehicles/?action=vehicle&invId=$singleReview[invId]'><span class='label'>$singleReview[invMake] $singleReview[invModel]</span></a> (Reviewed on $reviewDate)</td>"; 
        $reviews .= "<td><a class='grow modify' href='/phpmotors/reviews?action=edit-review&reviewId=$singleReview[reviewId]' title='Click to edit'>Edit</a></td>"; 
        $reviews .= "<td><a class='grow delete' href='/phpmotors/reviews?action=delete-review&reviewId=$singleReview[reviewId]' title='Click to delete'>Delete</a></td>";
        $reviews .= "</tr>";
       }
    $reviews .= "</table>";
    return $reviews;
}

// Function to format dates for reviews
function formatReviewDate($dateString) {
    return date ("d F, Y", strtotime($dateString));
}


/************************************
 * FUNCTIONS FOR WORKING WITH IMAGES
 * ************************************
****************************************/
// Adds "-tn" designation to file name
function makeThumbnailName($image) {
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
   }

// Build images display for image management view
function buildImageDisplay($imageArray) {
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
     $id .= '<li>';
     $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
     $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
     $id .= '</li>';
   }
    $id .= '</ul>';
    return $id;
   }

// Build the vehicles select list
function buildVehiclesSelect($vehicles) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Vehicle</option>";
    foreach ($vehicles as $vehicle) {
     $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
   }

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
     // Gets the actual file name
     $filename = $_FILES[$name]['name'];
     if (empty($filename)) {
      return;
     }
    // Get the file from the temp folder on the server
    $source = $_FILES[$name]['tmp_name'];
    // Sets the new path - images folder in this directory
    $target = $image_dir_path . '/' . $filename;
    // Moves the file to the target folder
    move_uploaded_file($source, $target);
    // Send file for further processing
    processImage($image_dir_path, $filename);
    // Sets the path for the image for Database storage
    $filepath = $image_dir . '/' . $filename;
    // Returns the path where the file is stored
    return $filepath;
    }
   }

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';
   
    // Set up the image path
    $image_path = $dir . $filename;
   
    // Set up the thumbnail image path
    $image_path_tn = $dir.makeThumbnailName($filename);
   
    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);
   
    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
   }

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
     
    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];
   
    // Set up the function names
    switch ($image_type) {
    case IMAGETYPE_JPEG:
     $image_from_file = 'imagecreatefromjpeg';
     $image_to_file = 'imagejpeg';
    break;
    case IMAGETYPE_GIF:
     $image_from_file = 'imagecreatefromgif';
     $image_to_file = 'imagegif';
    break;
    case IMAGETYPE_PNG:
     $image_from_file = 'imagecreatefrompng';
     $image_to_file = 'imagepng';
    break;
    default:
     return;
   } // ends the swith
   
    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
   
    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;
   
    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {
   
     // Calculate height and width for the new image
     $ratio = max($width_ratio, $height_ratio);
     $new_height = round($old_height / $ratio);
     $new_width = round($old_width / $ratio);
   
     // Create the new image
     $new_image = imagecreatetruecolor($new_width, $new_height);
   
     // Set transparency according to image type
     if ($image_type == IMAGETYPE_GIF) {
      $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagecolortransparent($new_image, $alpha);
     }
   
     if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
      imagealphablending($new_image, false);
      imagesavealpha($new_image, true);
     }
   
     // Copy old image to new image - this resizes the image
     $new_x = 0;
     $new_y = 0;
     $old_x = 0;
     $old_y = 0;
     imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
   
     // Write the new image to a new file
     $image_to_file($new_image, $new_image_path);
     // Free any memory associated with the new image
     imagedestroy($new_image);
     } else {
     // Write the old image to a new file
     $image_to_file($old_image, $new_image_path);
     }
     // Free any memory associated with the old image
     imagedestroy($old_image);
   } // ends resizeImage function