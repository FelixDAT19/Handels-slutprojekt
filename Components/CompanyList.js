import React, {useState} from "react";


function CompanyList({company}) {// list with companies and what exact placements they have

  return (
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
  );
}

export default CompanyList;

