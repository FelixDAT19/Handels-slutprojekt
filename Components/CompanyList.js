import React, {useState} from "react";


function CompanyList({company}) {

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

