import React, {useState} from "react";


function CompanyList({company}) {// list with companies and what exact placements they have

  return (

    <nav className="companyDropdownNav">
    <label htmlFor="btn" className="first dropdownButton">Företag
    <span className="fas fa-caret-down"></span>
    </label>
    <input type="checkbox" id="btn" className="dropdownCheckbox"/>
    <ul className="menuCompany firstUl">

    {company.map(({name,placement}, o ) => (
            <li key={o} className="listItems firstLI">
               <label htmlFor="btn-2" className="second dropdownButton">{name}
               <span className="fas fa-caret-down"></span>
               </label>
               <input type="checkbox" id="btn-company" className="dropdownCheckbox"/>
               <ul className="menuCompany secondUl">
                    {placement.map((i, key) => 
                        <li key={key} className="listItems secondLI"><p className="placeText">{i.id+ " "}</p></li>
                    )}
                  
               </ul>
            </li>
    ))}

    </ul>
 </nav>

  );
}

export default CompanyList;


/* 

    <div className="dropdown">
        <button className="dropbtn">Företag</button>
        <div className="dropdown-content">
            {company.map(({name,placement}, o ) => (
                <p key={o}>
                    {name+ " platser: "}
                    {placement.map((i, key) => 
                        <span key={key}>{i.id+ " "}</span>
                    )}
                </p>
            ))}
        </div>
    </div> 

           <li><a href="#">Home</a></li>
       <li>
          <label for="btn-2" class="first">Features
          <span class="fas fa-caret-down"></span>
          </label>
          <input type="checkbox" id="btn-2"/>
          <ul>
             <li><a href="#">Pages</a></li>
          </ul>
       </li>
       <li>
          <label for="btn-3" class="second">Services
          <span class="fas fa-caret-down"></span>
          </label>
          <input type="checkbox" id="btn-3"/>
          <ul>
             <li><a href="#">Web Design</a></li>
             <li><a href="#">App Design</a></li>
          </ul>
       </li>
       <li><a href="#">Contact</a></li>
       <li><a href="#">Feedback</a></li>

*/

