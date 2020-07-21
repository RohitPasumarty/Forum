<?php

session_start();

if(isset($_SESSION['id']))
{
?>

<!DOCTYPE html>
<html>
<head>
	<title>Forum</title>
	<meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="main.css?version=3.2">
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    	var eid;
    	var cid;
    	$(document).ready(function(){
    		$('.addtopics').click( function(){
    			document.getElementsByClassName("tname")[0].value="";
    			document.getElementsByClassName("tcontent")[0].value="";
    			$('#myForm').css("display","block");
    		});

            $('.cancel').click(function(){
    			$("#myForm").css("display","none");
    		});
            $('.form-container').submit( function(){
            	var topic = $(".tname").val();
				var content = $(".tcontent").val();
				$.post("topic.php",{
                   topic:topic,
                   content:content
				},
				function(data,status){
                   $("#myForm").css("display","none");
                   var field = $("<div></div>").html(data);
                   $(".addtopics").after(field);
				});
				return false;
    		});
    		$('.cancel2').click(function(){
	    	    $("#myForm2").css("display","none");
	    	});

	    	$('.form-container2').submit( function(){
				var content = $(".tcontent2").val();
				var num = parseInt(eid);
				$.post("topic.php",{
	               editcontent:content,
	               id:num
				},
				function(data,status){
	               $("#myForm2").css("display","none");
	               var div = document.getElementsByClassName(eid)[0];
	               div.getElementsByClassName("contentajax")[0].innerHTML=data;
	            });
				return false;
			});
			$('.cancel3').click(function(){
	    	    $("#myForm3").css("display","none");
	    	});

			$('.form-container3').submit( function(){
				var comment = $(".tcomment").val();
				var cname = "comment" + cid.split(" ")[1];
				var parent = document.getElementsByClassName(cid)[0];
				var upd = parent.parentElement.className;
                var update = document.getElementsByClassName(upd)[0].getElementsByClassName("c")[0];
                upd = parseInt(upd);
				$.post("topic.php",{
				   cname:cname,
	               comment:comment,
	               cupd:upd
				},
				function(data,status){
	                $("#myForm3").css("display","none");	                
                    var text = parent.innerHTML;
                    var count = parseInt(update.innerHTML);
                    count++;
                    update.innerHTML = count;
                    text = data + text;
                    parent.innerHTML = text;                   
	            });
				return false;
			});
        });
        function voteup(){
        	var x = this.parentElement.className;
	        var div = document.getElementsByClassName(x)[0];
            if(div.getElementsByClassName("down")[0].disabled)
            {
	            var id = parseInt(x);
	            var req = div.getElementsByClassName("upv")[0];
	            var up = parseInt(req.innerHTML);
	            up--;
				$.post("topic.php",{
	               upvotes:up,
	               id:id
				},
				function(data,status){
	               div.getElementsByClassName("down")[0].disabled = false;
	               req.innerHTML = data;
				});
				
			}
			else
			{
	            var id = parseInt(x);
	            var req = div.getElementsByClassName("upv")[0];
	            var up = parseInt(req.innerHTML);
	            up++;
				$.post("topic.php",{
	               upvotes:up,
	               id:id
				},
				function(data,status){
	               div.getElementsByClassName("down")[0].disabled = true;
	               req.innerHTML = data;
				});
				
			}	
		}
		function votedown(){
        	var x = this.parentElement.className;
	        var div = document.getElementsByClassName(x)[0];
            if(div.getElementsByClassName("up")[0].disabled)
            {
	            var id = parseInt(x);
	            var req = div.getElementsByClassName("downv")[0];
	            var down = parseInt(req.innerHTML);
	            down--;
				$.post("topic.php",{
	               downvotes:down,
	               id:id
				},
				function(data,status){
	               div.getElementsByClassName("up")[0].disabled = false;
	               req.innerHTML = data;
				});
				
			}
			else
			{
	            var id = parseInt(x);
	            var req = div.getElementsByClassName("downv")[0];
	            var down = parseInt(req.innerHTML);
	            down++;
				$.post("topic.php",{
	               downvotes:down,
	               id:id
				},
				function(data,status){
	               div.getElementsByClassName("up")[0].disabled = true;
	               req.innerHTML = data;
				});
				
			}	
		}
		function editContent(){
			document.getElementsByClassName("tcontent2")[0].value="";
    	    $('#myForm2').css("display","block");
    	    eid = this.parentElement.className;
		}
    	
    	function deleteContent()
    	{
    		if(confirm("Are You Sure You Want to Delete this Content?"))
    		{
	    		var did = this.parentElement.className;
	    		var id = parseInt(did);
	    		$.post("topic.php",{
	               did:id
				},
				function(data,status){
	               var del = document.getElementsByClassName(did)[0];
	               del.remove();
				});
			}
    	}

    	function openComment(){
    		var x = this.parentElement.className;
    		var open = document.getElementsByClassName(x)[0];
    		open.getElementsByClassName("comment-popup")[0].style.display = "block";
    		open.getElementsByClassName("close")[0].style.display = "block";
    	}

    	function postComment(){
    	    cid = this.parentElement.className;
    	    var tcname = "comment"+cid.split(" ")[1];
    	    $.post("topic.php",{
                tcname:tcname
			},function(data,status){
				document.getElementsByClassName("tcomment")[0].value="";
                $('#myForm3').css("display","block");
			});
    	}

    	function closeComment(){
    		var x = this.parentElement.className;
    		var close = document.getElementsByClassName(x)[0];
    		close.getElementsByClassName("comment-popup")[0].style.display = "none";
    		close.getElementsByClassName("close")[0].style.display = "none";
    	}

    	function deleteComment(){
            if(confirm("Are You Sure You Want to Delete this Comment?"))
    		{
	    		var dt = this.parentElement.className;
                var dx = dt.split("t")[1];
	    		var id = parseInt(dx);	    		
	    		var x = document.getElementsByClassName(dt)[0].parentElement.className;
	    		alert(x);
	    		var dtx = x.split(" ")[1];
	    		dtc = "comment"+dtx;
	    		dtx = parseInt(dtx);
	    		var update = document.getElementsByClassName(dtx)[0].getElementsByClassName("c")[0];
	            var count = parseInt(update.innerHTML);
	            count--;
	    		$.post("topic.php",{
	                delete:dtc,
	                cid:id,
	                count:count,
	                dtx:dtx
				},
				function(data,status){
	               var del=document.getElementsByClassName(dt)[0];
	               del.remove();
	               update.innerHTML=data;	               
				});
			}
    	}
    </script>
</head>
<body>
	<header class="cleartrick">
		<div class="lefthome">
	        <div class="p"><h1>Forum</h1></div>
		</div>
		<div class="righthome">
			<form action="logout.php" method="POST">
	            <button type="submit" name="logout" class="logout">Logout</button>
	        </form>
		</div>
	</header>
	<div class="container">
		<?php
		    echo '<div class="name">Welcome '.$_SESSION['firstname'].' '.$_SESSION['lastname'].'!</div>';
		?>
	</div>
	<div class="topics">
		<button type="submit" class="addtopics">+Add Topics</button>
		<?php
		    require 'connect.php';
            $sql = "SELECT * FROM topics";
		    $result = mysqli_query($conn,$sql);
		    while($row = mysqli_fetch_assoc($result))
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
                            echo '<div class=comment"'.$rowc['id'].'" id="style">';
                            echo '<h3>'.$rowc['username'].'</h3>';
                            echo '<p>'.$rowc['comment'].'</p>';
                            echo '<button class="btncomment" onclick="deleteComment.call(this)">Delete</button>';
                            echo '</div>';
                        }
                        else
                        {
                            echo '<div class=comment"'.$rowc['id'].'" id="style">';
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
		?>

	</div>
	<div class="topic-popup vertical-center" id="myForm">
		<form class="form-container" method="POST">
		    <h1>Add Topic</h1><br>
            <input type="text" name="name" class="tname" placeholder="Topic Name" required><br><br>
		    <textarea placeholder="Add Content" name="content" class="tcontent" required></textarea><br><br>
		    <button type="submit" class="btn subtopic" name="topic">Send</button>
		    <button type="button" class="btn cancel">Discard</button>
		</form>
    </div>
    <div class="topic-popup2 vertical-center" id="myForm2">
		<form class="form-container2" method="POST">
		    <h1>Edit Content</h1><br>
		    <textarea placeholder="New Content" name="content" class="tcontent2" required></textarea><br><br>
		    <button type="submit" class="btn subtopic2" name="topic">Confirm</button>
		    <button type="button" class="btn cancel2">Discard</button>
		</form>
    </div>
    <div class="comment-box vertical-center" id="myForm3">
		<form class="form-container3" method="POST">
		    <h1>Add Comment</h1><br>
		    <textarea placeholder="Add Comment" name="content" class="tcomment" required></textarea><br><br>
		    <button type="submit" class="btn subcomment" name="topic">Confirm</button>
		    <button type="button" class="btn cancel3">Discard</button>
		</form>
    </div>
</body>
</html>

<?php
}
else 
{
	header('Location: index.php');
}
?>