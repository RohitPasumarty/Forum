<?php
    require 'connect.php';
    session_start();
    if(isset($_POST['topic']))
    {
	    $sql = "INSERT INTO topics (topic,content,author) VALUES (?,?,?)";
	    $stmt = mysqli_stmt_init($conn);
	    if(!mysqli_stmt_prepare($stmt,$sql))
	    {
	        header('Location: home.php?error=sqlerror');
	        exit();
	    }
	    else
	    {
	    	$author = $_SESSION['firstname'];
	    	$content = $_POST['content'];
	    	$topic = $_POST['topic'];
	        mysqli_stmt_bind_param($stmt , "sss" ,$topic,$content,$author);
	        if(!mysqli_stmt_execute($stmt))
	        {
	            echo 'could not add data';
	            exit();
	        }
	        else
	        {
	            $sql = "SELECT * FROM topics WHERE topic= ? AND content= ?";
		        $stmt = mysqli_stmt_init($conn);
		        if(!mysqli_stmt_prepare($stmt,$sql))
		        {
		            echo 'could not find data';
		            exit();
		        }
		        else
		        {
		            mysqli_stmt_bind_param($stmt , "ss" , $topic, $content);
		            mysqli_stmt_execute($stmt);
		            $result = mysqli_stmt_get_result($stmt);
		            if($row = mysqli_fetch_assoc($result))
		            {
		            	echo '<div class="'.$row['id'].'">';
		            	echo '<h2>'.$row['topic'].'</h2>';
			    	    echo '<p class="contentajax">'.$row['content'].'</p>';
			    	    echo '<button class="btntopic up" onclick="voteup.call(this)">Upvotes <span class="upv">'.$row['upvotes'].'</span></button>';
			    	    echo '<button class="btntopic down" onclick="votedown.call(this)">Downvotes <span class="downv">'.$row['downvotes'].'</span></button>';
			    	    echo '<button class="btntopic" onclick="editContent.call(this)">Edit Content</button>';
			    	    echo '<button class="btntopic" onclick="deleteContent.call(this)">Delete Content</button>';
			    	    echo '<button class="btntopic" onclick="openComment.call(this)">Comments <span class="c">'.$row['comments'].'</span></button>';
			    	    if($row['comments']>0)
				        {
				        	$tname = 'comment'.$row['id'];
				        	echo '<div class="comment-popup '.$row['id'].'">';
		                    $sqlc = "SELECT * FROM ".$tname;
		                    $resultc = mysqli_query($conn,$sqlc);
		                    while($rowc=mysqli_fetch_assoc($resultc))
		                    {
		                    	if($_SESSION['acctype']=="a")
		                        {
		                            echo '<div class="comment'.$rowc['id'].'" id="style">';
		                            echo '<h3>'.$rowc['username'].'</h3>';
		                            echo '<p>'.$rowc['comment'].'</p>';
		                            echo '<button class="btncomment" onclick="deleteComment.call(this)">Delete</button>';
		                            echo '</div>';
		                        }
		                        else
		                        {
		                            echo '<div class="comment'.$rowc['id'].'" id="style">';
		                            echo '<h3>'.$rowc['username'].'</h3>';
		                            echo '<p>'.$rowc['comment'].'</p>';
		                            echo '</div>';
		                        }
		                    }
		                    echo '<button class="btncomment post" onclick="postComment.call(this)">Post</button>';
		                    echo '</div>';
				        }
				        else
				        {
				        	echo '<div class="comment-popup '.$row['id'].'">';
		                    echo '<button class="btncomment post" onclick="postComment.call(this)">Post</button>';
		                    echo '</div>';                   
				        }
				    	echo '<button class="btntopic close" onclick="closeComment.call(this)">Close</button>';
				    	echo '</div>';
		            }
		        }
	        }
	    }	
	}
	else if(isset($_POST['upvotes']))
	{
		$upvotes = $_POST['upvotes'];
		$id = $_POST['id'];
        $sql = "UPDATE topics SET upvotes=? WHERE id=?";
	    $stmt = mysqli_stmt_init($conn);
	    if(!mysqli_stmt_prepare($stmt,$sql))
	    {
	        header('Location: home.php?error=sqlerror');
	        exit();
	    }
	    else
	    {
	    	mysqli_stmt_bind_param($stmt , "ii" , $upvotes,$id);
		    if(!mysqli_stmt_execute($stmt))
		    {
		    	header('Location: home.php?error=sqlerror');
	            exit();
		    }
		    else
		    {
		    	echo $upvotes;
		    }
	    }
	}
	else if(isset($_POST['downvotes']))
	{
		$downvotes = $_POST['downvotes'];
		$id = $_POST['id'];
        $sql = "UPDATE topics SET downvotes=? WHERE id=?";
	    $stmt = mysqli_stmt_init($conn);
	    if(!mysqli_stmt_prepare($stmt,$sql))
	    {
	        header('Location: home.php?error=sqlerror');
	        exit();
	    }
	    else
	    {
	    	mysqli_stmt_bind_param($stmt , "ii" , $downvotes,$id);
		    if(!mysqli_stmt_execute($stmt))
		    {
		    	header('Location: home.php?error=sqlerror');
	            exit();
		    }
		    else
		    {
		    	echo $downvotes;
		    }
	    }
	}
	else if(isset($_POST['editcontent']))
	{
		$contentajax = $_POST['editcontent'];
		$id = $_POST['id'];
        $sql = "UPDATE topics SET content=? WHERE id=?";
	    $stmt = mysqli_stmt_init($conn);
	    if(!mysqli_stmt_prepare($stmt,$sql))
	    {
	        header('Location: home.php?error=sqlerror');
	        exit();
	    }
	    else
	    {
	    	mysqli_stmt_bind_param($stmt , "si" , $contentajax,$id);
		    if(!mysqli_stmt_execute($stmt))
		    {
		    	header('Location: home.php?error=sqlerror');
	            exit();
		    }
		    else
		    {
		    	echo $contentajax;
		    }
	    }
	}
	else if(isset($_POST['did']))
	{
		$id = $_POST['did'];
        $sql = "DELETE FROM topics WHERE id=?";
	    $stmt = mysqli_stmt_init($conn);
	    if(!mysqli_stmt_prepare($stmt,$sql))
	    {
	        header('Location: home.php?error=sqlerror');
	        exit();
	    }
	    else
	    {
	    	mysqli_stmt_bind_param($stmt , "i" ,$id);
		    if(!mysqli_stmt_execute($stmt))
		    {
		    	header('Location: home.php?error=sqlerror');
	            exit();
		    }
		    else
		    {
		    	$sql = "DROP TABLE comment".$id;
		    	$stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_execute($stmt);
		    }
	    }
	}
	else if(isset($_POST['delete']))
	{
		$delete = $_POST['delete'];
		$cid = $_POST['cid'];
		$count = $_POST['count'];
		$dtx = $_POST['dtx'];
        $sql = "DELETE FROM ".$delete." WHERE id=?";
	    $stmt = mysqli_stmt_init($conn);
	    if(!mysqli_stmt_prepare($stmt,$sql))
	    {
	        header('Location: home.php?error=sqlerror');
	        exit();
	    }
	    else
	    {
	    	mysqli_stmt_bind_param($stmt , "i" ,$cid);
		    if(!mysqli_stmt_execute($stmt))
		    {
		    	header('Location: home.php?error=sqlerror');
	            exit();
		    }
		    else
		    {
			    $sql = "UPDATE topics SET comments=? WHERE id=?";
			    $stmt = mysqli_stmt_init($conn);
			    if(!mysqli_stmt_prepare($stmt,$sql))
			    {
			        header('Location: home.php?error=sqlerror');
			        exit();
			    }
			    else
			    {
			    	mysqli_stmt_bind_param($stmt , "ii" ,$count,$dtx);
				    if(!mysqli_stmt_execute($stmt))
				    {
				    	header('Location: home.php?error=sqlerror');
			            exit();
				    }
				    else
				    {
				    	echo $count;
				    }
				    
			    }
			}
	    }
	}
	else if(isset($_POST['tcname']))
	{
		$tcname = $_POST['tcname'];
		$sql = "SELECT * FROM ".$tcname;
		$result = mysqli_query($conn,$sql);
		if(!$result)
		{
			$sql2 = "CREATE TABLE ".$tcname."( id INT NOT NULL AUTO_INCREMENT , username VARCHAR(100) NOT NULL , comment LONGTEXT NOT NULL,primary key(id))";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt,$sql2))
			{
				header('Location: home.php?error=sqlerror');
		        exit();
			}
			else
			{
				if(!mysqli_stmt_execute($stmt))
				{
                    header('Location: home.php?error=sqlerror');
		            exit();
				}
			}
		}
	}
	else if(isset($_POST['comment']))
	{
		$cname = $_POST['cname'];
		$cusername = $_SESSION['username'];
		$comment = $_POST['comment'];
		$cupd = $_POST['cupd'];
		$sql = "INSERT INTO ".$cname."(username,comment) VALUES (?,?)";
	    $stmt = mysqli_stmt_init($conn);
	    if(!mysqli_stmt_prepare($stmt,$sql))
	    {
	        header('Location: home.php?error=sqlerror');
	        exit();
	    }
	    else
	    {
	    	mysqli_stmt_bind_param($stmt , "ss" , $cusername,$comment);
		    if(!mysqli_stmt_execute($stmt))
		    {
		    	header('Location: home.php?error=sqlerror');
	            exit();
		    }
		    else
		    {
		    	$sqlc = "SELECT * FROM ".$cname." WHERE username= ? AND comment= ?";
		        $stmtc = mysqli_stmt_init($conn);
		        mysqli_stmt_prepare($stmtc,$sqlc);
		        mysqli_stmt_bind_param($stmtc , "ss" , $cusername, $comment);
		        if(!mysqli_stmt_execute($stmtc))
		        {

		        }
		        else
		        {
                    $resultc = mysqli_stmt_get_result($stmtc);
	                while($rowc=mysqli_fetch_assoc($resultc))
	                {
	                	if($_SESSION['acctype']=="a")
	                    {
	                        echo '<div class="comment'.$rowc['id'].'" id="style">';
	                        echo '<h3>'.$rowc['username'].'</h3>';
	                        echo '<p>'.$rowc['comment'].'</p>';
	                        echo '<button class="btncomment" onclick="deleteComment.call(this)">Delete</button>';
	                        echo '</div>';
	                    }
	                    else
	                    {
	                        echo '<div class="comment'.$rowc['id'].'" id="style">';
	                        echo '<h3>'.$rowc['username'].'</h3>';
	                        echo '<p>'.$rowc['comment'].'</p>';
	                        echo '</div>';
	                    }
	                }
		        }
		        $sql = "UPDATE topics SET comments=comments+1 WHERE id=?";
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt,"i",$cupd);
                mysqli_stmt_execute($stmt);
		    }
	    }
	}

?>