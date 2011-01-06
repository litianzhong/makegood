/**
 * Copyright (c) 2010 KUBO Atsuhiro <kubo@iteman.jp>,
 * All rights reserved.
 *
 * This file is part of MakeGood.
 *
 * This program and the accompanying materials are made available under
 * the terms of the Eclipse Public License v1.0 which accompanies this
 * distribution, and is available at http://www.eclipse.org/legal/epl-v10.html
 */

package com.piece_framework.makegood.aspect.com.piece_framework.makegood.core;

import org.eclipse.ui.IStartup;

import com.piece_framework.makegood.aspect.com.piece_framework.makegood.core.aspect.PHPFlagsAspect;
import com.piece_framework.makegood.javassist.Aspect;
import com.piece_framework.makegood.javassist.PDTVersion;
import com.piece_framework.makegood.javassist.WeavingProcess;

/**
 * @since 1.2.0
 */
public class FragmentWeavingProcess extends WeavingProcess implements IStartup {
    private static final Aspect[] ASPECTS = {
        new PHPFlagsAspect()
    };

    @Override
    public void earlyStartup() {
        process();
        MonitorTarget.endWeaving = true;
    }

    @Override
    protected String pluginId() {
        return Fragment.ID;
    }

    @Override
    protected Aspect[] aspects() {
        return ASPECTS;
    }

    @Override
    protected String[] dependencies() {
        return PDTVersion.getInstance().compareTo("2.2.0") >= 0 ? //$NON-NLS-1$
                   new String[] {
                       "com.piece_framework.makegood.core" //$NON-NLS-1$
                   } :
                   new String[] {
                       "com.piece_framework.makegood.core", //$NON-NLS-1$
                       "org.eclipse.php.core" //$NON-NLS-1$
                   };
    }
}
