// IdleUpgrade object holds data values pertaining to an item,
// All must be assigned on creation and itemBenefit passed as value per sec,
class IdleUpgrade {
  constructor(itemID, itemCost, itemBenefit) {
    this.ID = itemID;
    this.cost = itemCost;
    this.benefit = itemBenefit / 1000; // converts passed value to ms
    this.itemCount = 0;
  }
}

const cssRoot = document.querySelector(":root"); // Gets global CSS variables

let internalCounter = 0; // Initializes internalCounter to 0
const outputCounter = document.getElementById("input-El"); // Gets html element where internalCounter is displayed

    let clickSound = new Audio("audio/notification-2.mp3");
    let buySound = new Audio("audio/button-pressed-38129.mp3");

let totalScroll = 0;
document.addEventListener("scroll", (e) => {
  // Used to correct mouse pos in updateCounter
  totalScroll = window.scrollY;
});

document.getElementById("crab").onclick = updateCounter; // When image is clicked calls updateCounter

document.getElementById("itemContainer").onclick = buyItem; // Calls buyItem when ever user clicks on itemContainer wrapper

// *** Creating store items *************************************

let itemOne = new IdleUpgrade("firstItem", 30, 1);
let itemTwo = new IdleUpgrade("secondItem", 45, 3);
let itemThree = new IdleUpgrade("thirdItem", 60, 5);
let itemFour = new IdleUpgrade("fourthItem", 100, 8);
let itemFive = new IdleUpgrade("fithItem", 250, 15);

let itemIdArray = [itemOne, itemTwo, itemThree, itemFour, itemFive]; // Array of items

if (!document.getElementById("signUpButton")) {
  itemOne.itemCount = document.getElementById("firstItemCount").innerHTML;
  itemTwo.itemCount = document.getElementById("secondItemCount").innerHTML;
  itemThree.itemCount = document.getElementById("thirdItemCount").innerHTML;
  itemFour.itemCount = document.getElementById("fourthItemCount").innerHTML;
  itemFive.itemCount = document.getElementById("fithItemCount").innerHTML;

  //this loop looks for the cost of the itemarry and gets the new total that gets saved, this only happens after logging in
  itemIdArray.forEach((element) => {
    let intialEnd = element.cost;
    let intial = element.cost;
    for (let i = 0; i < element.itemCount; i++) {
      let sum = intialEnd + Math.round(intialEnd * 0.2);
      intialEnd = sum;
    }
    element.cost = intialEnd;
    document.getElementById(element.ID).innerHTML = document
      .getElementById(element.ID)
      .innerHTML.replace(intial, intialEnd);
  });

  internalCounter = outputCounter.innerHTML;
}

// *** Creating chat Page **************************************
const chatPage = document.getElementById("chatPage"); // Gets login page wrapper
document.getElementById("userChat").onclick = toggleChatPage; // Makes chat page visible / invisible

function toggleChatPage() {
  chatPage.classList.toggle("hidden");
}

if (document.getElementById("chatLoginBtn") != null) {
const chatBtn = document.getElementById("chatLoginBtn");

chatBtn.addEventListener("click", () => {
  toggleLoginPage();
});
}
// ****************************************************************************

// *** Creating leaderBoard Page **************************************
const gobalStatsPage = document.getElementById("gobalStatsPage"); // Gets login page wrapper
document.getElementById("gobalStats").onclick = toggleLeaderBoardPage; // Makes chat page visible / invisible

function toggleLeaderBoardPage() {
  gobalStatsPage.classList.toggle("hidden");
}

if (document.getElementById("statsBtn") != null) {
  const leaderBoardBtn = document.getElementById("statsBtn");

  leaderBoardBtn.addEventListener("click", () => {
    toggleLoginPage();
  });
}

function reloadLB() {
  window.location.reload();
}

// *** Creating Login Page **************************************
const LoginPage = document.getElementById("loginPage"); // Gets login page wrapper

document.getElementById("userProfile").onclick = toggleLoginPage; // Makes login page visible / invisible

const emailTextBox = document.getElementById("Email"); // Email text tag in login page

const passwordTextBox = document.getElementById("Password"); // password text tag in login page

let loginPressed = false; // Holds true when user submits login information

// If the user has not logged in then this element exist otherwise it does not
if (document.getElementById("submitLogin") != null) {
  document.getElementById("submitLogin").addEventListener("click", function () {
    // Event listener for login submit
    if (
      emailTextBox.value != "" &&
      passwordTextBox.value.length >= passwordTextBox.minLength
    ) {
      loginPressed = true;
    }
  });
}

//If when page loads the login form is opened it is closed
if (LoginPage.classList.contains("show")) {
  toggleLoginPage();
}

if (document.getElementById("signUpButton")) {
  document.getElementById("signUpButton").onclick = function () {
    document.loginForm.classList.toggle("hidden"); // Makes form visible or invisible
    document.signUpForm.classList.toggle("hidden"); // Makes form visible or invisible

    // If login form is not visible
    if (document.loginForm.classList.contains("hidden")) {
      // The signUp form is visible so a different message is shown
      document.getElementById("signUpButton").innerHTML = "Login";
      document.getElementById("signUpText").childNodes[0].nodeValue =
        "Already have an account? ";
    } else {
      // The login form is visible so a different message is shown
      document.getElementById("signUpButton").innerHTML = "SignUp";
      document.getElementById("signUpText").childNodes[0].nodeValue =
        "Don't have an account? ";
    }
  };
}

if (document.signUpForm) {
  document.signUpForm.onsubmit = function () {
    document.signUpForm.crabCount.value = outputCounter.innerHTML; // Gets current counter value
    document.signUpForm.firstCount.value = itemIdArray[0].itemCount; // Gets amount of item
    document.signUpForm.secondCount.value = itemIdArray[1].itemCount; // Gets amount of item
    document.signUpForm.thirdCount.value = itemIdArray[2].itemCount; // Gets amount of item
    document.signUpForm.fourthCount.value = itemIdArray[3].itemCount; // Gets amount of item
    document.signUpForm.fithCount.value = itemIdArray[4].itemCount; // Gets amount of item
    return true; // Allows for normal submission protocol
  };
}

if (document.saveForm) {
  document.saveForm.onsubmit = function () {
    document.saveForm.crabCount.value = outputCounter.innerHTML; // Gets current counter value
    document.saveForm.firstCount.value = itemIdArray[0].itemCount; // Gets amount of item
    document.saveForm.secondCount.value = itemIdArray[1].itemCount; // Gets amount of item
    document.saveForm.thirdCount.value = itemIdArray[2].itemCount; // Gets amount of item
    document.saveForm.fourthCount.value = itemIdArray[3].itemCount; // Gets amount of item
    document.saveForm.fithCount.value = itemIdArray[4].itemCount; // Gets amount of item
    return true; // Allows for normal submission protocol
  };
}

function updateCounter(event) {
  const x = event.clientX; // Gets current mouse position
  const y = event.clientY; // Gets current mouse position

  internalCounter = parseFloat(internalCounter) + 1; // Increments counter
  outputCounter.innerHTML = parseInt(internalCounter); // Sets output counter

  clickSound.play(); // Plays sound
  clickSound.currentTime = 0; // Resets sound incase of subsequent call

  cssRoot.style.setProperty("--mouseXPos", x - 20 + "px"); // Passes mouse coordinate to css var
  cssRoot.style.setProperty("--mouseYPos", y - 50 + totalScroll + "px"); // Passes mouse coordinate to css var

  // Create a square element
  const square = document.createElement("img");

  // square.src = "images/counter-icon.png";    // Image source
  square.src = "http://localhost/2ndCrab/images/crabclick.png";
  square.style.width = "50px"; // Set the square width
  square.style.height = "50px"; // Set the square height
  square.style.position = "absolute"; // Position the square absolutely
  square.style.left = x - 20 + "px"; // Set the left position
  square.style.top = y - 50 + "px"; // Set the top position
  square.className = "ani"; // This class contains animation details

  square.addEventListener("animationend", function () {
    // Removes the square from the page after animation
    square.remove(); //Removes element
  });

  document.getElementById("tempElements").appendChild(square); // Adds square to page under the div with id tempElements
}

function isPurchasable() {
  let passedButton; // Used to hold current button

  // Will loop through all items in itemIdArray
  itemIdArray.forEach((element) => {
    passedButton = document.getElementById(element.ID);
    if (parseInt(outputCounter.innerHTML) >= parseInt(element.cost)) {
      // If the user has more than the cost of the item it can be bought
      passedButton.style.backgroundColor = "green"; // Sets button to green indicating it can be bought
    } else {
      passedButton.style.backgroundColor = "grey"; // Sets button to grey indicating it can NOT be bought
    }
  });
}

function buyItem(event) {
  // event is a stand in for an event
  if (event.target.tagName === "BUTTON") {
    // If event is of type button
    const passedButton = document.getElementById(event.target.id); // Gets id of pressed button
    const itemText = document.getElementById(event.target.id + "Count"); // Gets corresponding item Count

    if (passedButton.style.backgroundColor !== "grey") {
      // Checks if user can buy item
      itemIdArray.forEach((element) => {
        // Iterates through items till correct one is found
        if (element.ID === event.target.id) {
           buySound.play();            // Plays sound
          // buySound.currentTime = 0;   // Resets sound

          internalCounter =
            parseFloat(internalCounter) - parseInt(element.cost); // Reduces count by cost of upgrade
          outputCounter.innerHTML = parseInt(internalCounter); // Changes output to new count
          itemText.innerHTML = parseInt(element.itemCount) + 1 ; // Displays new amount of item
          passedButton.innerHTML = passedButton.innerHTML.replace(
            element.cost,
            parseInt(element.cost) + Math.round(parseInt(element.cost) * 0.2)
          ); // Displays new cost

          element.cost += Math.round(parseInt(element.cost) * 0.2); // Increases cost by 20%
          element.itemCount = Number(element.itemCount) + 1; //Increases amount of item
        }
      });
    }
  }
}

function idleMultipliers(progress) {
  let sum = 0; // Will hold amount to be added from items (in ms)

  itemIdArray.forEach((element) => {
    // Goes through each item and adds up all idle gains by the amount of ms passed
    sum =
      parseFloat(sum) +
      parseFloat(element.benefit) * parseFloat(element.itemCount); // Amount of item times the amount of benefit it gives
  });

  internalCounter = parseFloat(internalCounter) + parseFloat(sum) * progress; // Increments count by sum

  outputCounter.innerHTML = Math.round(internalCounter); // Changes output count to new count
}

function setRate(msPassed) {
  let rate = (internalCounter - oldCount) / msPassed; // Calculates rate of change per ms
  if (rate >= 0) {
    // Rate should not include item purchases
    document.getElementById("crabSec").innerHTML ="Average: " + Math.round(rate * 1000); // Outputs rate per second as an integer
  }
}

function toggleLoginPage() {
  loginPressed = false; // Rests flag when login menu is opened
  LoginPage.classList.toggle("hidden"); // Removes class to make it visible

  // Generates darker background
  const tempSpan = document.createElement("span");
  tempSpan.id = "tempSpan";
  document.getElementById("tempElements").appendChild(tempSpan);

  tempSpan.addEventListener("click", function (event) {
    // If login is visible
    if (!LoginPage.classList.contains("hidden")) {
      // If submit was not clicked reset text fields
      if (!loginPressed && emailTextBox != null) {
        emailTextBox.value = "";
        passwordTextBox.value = "";
      }

      // If you click outside the menu then it is closed
      if (
        !LoginPage.contains(event.target) &&
        event.target != document.getElementById("loginPage")
      ) {
        LoginPage.classList.toggle("hidden");
        tempSpan.remove(); //Removes background element
      }
    }
  });
}

/********************
 * Main page loop   *
 ********************/
let progress = 0; // Will hold ms passed since last frame
let oldCount = 0; // Will hold count of last called setRate()
let timeElapsed = 0; // Will hold ms passed used to call setRate()

function loop(timestamp) {
  progress = timestamp - lastRender; // Accumulates time passed since last frame (ms)
  timeElapsed += progress; // Accumulates time passed for calling setRate()

  isPurchasable(); // Checks if item can be bought, if so turns it green

  idleMultipliers(progress); // Increments counter by idle gains

  if (timeElapsed >= 700) {
    // Gets and sets rate about every 700ms
    setRate(timeElapsed); // Calculates and sets rate of change of count
    oldCount = internalCounter; // Gets count for next setRate() call
    timeElapsed = 0; // Resets timer
  }

  lastRender = timestamp; // Gets new end time
  window.requestAnimationFrame(loop); //enters loop again aka new frame
}

var lastRender = 0; // Start of last frame is 0
window.requestAnimationFrame(loop);
