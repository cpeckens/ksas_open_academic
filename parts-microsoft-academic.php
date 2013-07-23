<?php $author_id = get_post_meta($post->ID, 'ecpt_microsoft_id', true);
		$api_key = '590653d5-7996-40b8-ad51-34426603139c';
		$microsoft_url = 'http://academic.research.microsoft.com/json.svc/search?AppId=' . $api_key . '&AuthorID=' . $author_id . '&ResultObjects=publication&PublicationContent=title,ConferenceAndJournalInfo&OrderType=year&StartIdx=1&EndIdx=25';
			$rCURL = curl_init();
				curl_setopt($rCURL, CURLOPT_URL, $microsoft_url);
				curl_setopt($rCURL, CURLOPT_HEADER, 0);
				curl_setopt($rCURL, CURLOPT_RETURNTRANSFER, 1);
		
		$microsoft_call = curl_exec($rCURL);
		curl_close($rCURL);
		$microsoft_results = json_decode( $microsoft_call, true );
		$microsoft_pubs = $microsoft_results['d']['Publication'];
		foreach($microsoft_pubs['Result'] as $microsoft_pub) { 

?>	

<p class="bold"><a href="http://academic.research.microsoft.com/Publication/<?php echo $microsoft_pub['ID'] ?>"><?php echo $microsoft_pub['Title'] ?></a><br>
<?php echo $microsoft_pub['Year'] ?> in <?php echo $microsoft_pub['Journal']['FullName'] ?></p>

<?php } ?>						