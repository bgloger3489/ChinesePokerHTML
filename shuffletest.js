//CONSTANTS
RANK = 0, SUIT = 1;
ACE = 1, JACK = 11, QUEEN = 12, KING = 13;
CLUB = 1, DIAMOND = 0, HEART = 2, SPADE = 3;

/*
	generateStandardDeck
	
	Creates a deck of standard playing cards as an array.
	
	returns
		The deck of cards
*/
function generateStandardDeck()
{
	//The deck starts as an empty array.
	var deck = [];
	
	/*
		A double for loop will create all 52 cards, running the 13 ranks each 4 times for the suits.
	*/
	for (var s = DIAMOND; s <= SPADE; s++)
	{
		for (var r = ACE; r <= KING; r++)
		{
			/*
				By declaring the card as an empty array, we can assign values to different associative indices using object notation.
			*/
			var card = new Object();
			card.rank = r;
			card.suit = s;
			card.cardImg = r + "-" + s;
			
			card.toBePlayed = false;
			//card.positionInHand = -1;
			
			//Add the card
			deck.push(card);
		}
	}	
	
	//return the completed array.
	return deck;
}

function shuffleDeck(deck){
	//console.log('asdsd');
	var tempDeck = [];
	while(deck.length > 0){
		var tempIndex = Math.floor(Math.random() * deck.length) + 0;
		tempDeck.push(deck[tempIndex]);
		deck.splice(tempIndex,1);
		/*var indexTemp = Math.floor(Math.random() * 52) + 0;
		//alert(i);
		var dataTemp = deckIn[indexTemp];
		deckIn[indexTemp] = deckIn[i];
		deckIn[i] = dataTemp;
		//Math.floor(Math.random() * 52) + 0*/
		
	}
	
	return tempDeck;
}

/*
	shuffleDeck
	
	Takes a deck of cards and randomizes the order of the cards.
	
	Parameters:
		deck - The deck of cards
		
	Returns:
		The shuffled deck
*/


/*
	dealCard
	
		Removes and returns the first card from a deck.
	
	Parameters:
		a card deck
		
	Returns:
		The removed card
*/
function dealCard(deck)
{
	var tempData = deck[0];
	deck = deck.splice(0,1);
	//alert(deck.length);
	
	return tempData;
}

/*
	addCard
	
		Adds a card to the bottom of a deck.
		
		Parameters:
			deck - the card deck
			card - the card being added to the deck.
*/
function addCard(deck, card)
{
	deck.push(card);
}

