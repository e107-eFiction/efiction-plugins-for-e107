
<div class=" property-detail">    
    <img src="{storyimage}" alt="{storytitle}" class="rounded mx-auto d-block">
    <div id="sort"> [{reviews} - {numreviews}] {score}{printicon}</div>
    <div class="service-column row mt-3">                    
        <div class="inner-column col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="service-block wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">                            
                <div class="inner-box">                                
                    <span class="icon flaticon-user">
                    </span><h4>Prekladateľ:</h4>                                
                    <div class="text">{author}
                    </div>                            
                </div>                        
            </div>    
        </div>  
        <div class="inner-column col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="service-block wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">                            
                <div class="inner-box">                                
                    <span class="icon flaticon-notebook">
                    </span><h4>Autor originálu:</h4>                                
                    <div class="text">{writer}
                    </div>                            
                </div>                        
            </div>    
        </div> 
    </div>
     <div class="service-column row">                    
        <div class="inner-column col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="service-block wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">                            
                <div class="inner-box">                                
                    <span class="icon flaticon-unlink">
                    </span><h4>Názov originálu:</h4>                                
                    <div class="text">{original_link}
                    </div>                            
                </div>                        
            </div>    
        </div>  
        <div class="inner-column col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="service-block wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">                            
                <div class="inner-box">                                
                    <span class="icon flaticon-pin">
                    </span><h4>Link na preklad:</h4>                                
                    <div class="text">{translation_link}
                    </div>                            
                </div>                        
            </div>    
        </div> 
                        
    </div> 
        
    <div class="jumbotron jumbotron-sm">{summary} </div>
    
    <h4>Details</h4> 
	<div class="row"> 
    <div class="table-outer col-md-6">  	
        <table class="info-table">  		
            <tr>  			<td><strong>Rating:</strong> {rating}</td>  		   		
            </tr>  		
            <tr>  			<td><strong>Characters:</strong> {characters}</td>  			 	
            </tr>  		
            <tr>  			<td><strong>Chapters:</strong> {numchapters} {toc}</td>  			 		
            </tr>  		
            <tr>  			<td><strong>Word count:</strong> {wordcount}</td>  			 
            </tr>  		
            <tr>  			<td><strong>Published:</strong> {published}</td>  			 
            </tr>  	
        </table>  
    </div>
     <div class="table-outer col-md-6">  	
        <table class="info-table">  		
            <tr>  		 <td><strong>Category:</strong> {category}</td>  		
            </tr>  		
            <tr>  		 <td><strong>Series:</strong> {serieslinks}</td>  		
            </tr>  		
            <tr>  	 <td><strong>Completed:</strong> {completed}</td>  		
            </tr>  		
            <tr>  	 <td><strong>Read Count:</strong> {count}</td>  		
            </tr>  		
            <tr>  	 <td><strong>Updated:</strong> {updated} </td>  		
            </tr>  	
        </table>  
    </div>  
	</div>
    
    {classifications}    
    <div class="tail">
    <span class="label">{addtofaves} {reportthis}   
    </span> 
    </div>
<div class="jumpmenu">{jumpmenu}
    </div>
    {featuredstory} {adminlinks} 
</div> 
 
 
   
        <!-- START BLOCK : storynotes -->
        <div class='notes'>
            <div class='title'>
                <span class='label'>Story Notes:
                </span>
            </div>
            <div class='noteinfo'>{storynotes}
            </div>
        </div>
        <!-- END BLOCK : storynotes -->
        <!-- START BLOCK : storyindexblock -->      
        <p><b>{chapternumber}. {title} </b>by {author} [{reviews} - {numreviews}] {ratingpics} ({wordcount} words)<br />	{chapternotes}{adminoptions}
        </p>
        <!-- END BLOCK : storyindexblock -->{storyend}{last_read} 
        <div id="pagelinks">
            <div class="jumpmenu">{jumpmenu2}
            </div>
        </div>
        <div class="respond">{roundrobin}
        </div>{reviewform} 

 